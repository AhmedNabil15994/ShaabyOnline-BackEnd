<?php

namespace Modules\Catalog\Repositories\WebService;

use Modules\Catalog\Entities\Category;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\VendorProduct;
use Modules\Catalog\Traits\CatalogTrait;
use Modules\Core\Traits\CoreTrait;
use Modules\Variation\Entities\Option;
use Modules\Variation\Entities\ProductVariant;
use Modules\Vendor\Entities\Vendor;

class CatalogRepository
{
    use CatalogTrait, CoreTrait;

    protected $category;
    protected $product;
    protected $vendor;
    protected $prd;
    protected $prdVariant;
    protected $option;
    protected $defaultVendor;

    public function __construct(
        VendorProduct $product,
        Product $prd,
        Category $category,
        Vendor $vendor,
        ProductVariant $prdVariant,
        Option $option
    ) {
        $this->category = $category;
        $this->product = $product;
        $this->vendor = $vendor;
        $this->prd = $prd;
        $this->prdVariant = $prdVariant;
        $this->option = $option;

        $this->defaultVendor = app('vendorObject') ?? null;
    }

    public function getLatestNCategories($request)
    {
        $categories = $this->buildCategoriesTree($request);
        $count = $request->categories_count ?? 8;
        return $categories->where('show_in_home', 1)->orderBy('sort', 'asc')->take($count)->get();
    }

    public function getAllCategories($request)
    {
        $categories = $this->buildCategoriesTree($request);
        $categories = $categories->orderBy('sort', 'asc');
        if (!empty($request->categories_count)) {
            $categories = $categories->take($request->categories_count);
        }

        return $categories->get();
    }

    public function getAllMainCategories($request, $withRelations = [])
    {
        $categories = $this->category->query();
        if (!empty($withRelations)) {
            $categories->with($withRelations);
        }

        return $categories->active()->mainCategories()->orderBy('sort', 'asc')->get();
    }

    public function getFilterOptions($request)
    {
        return $this->option->active()
            ->with(['values' => function ($query) {
                $query->active();
            }])
            ->activeInFilter()
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function getAutoCompleteProducts($request)
    {
        $products = $this->prd->active()->whereHas('vendor', function ($query) {
            $query->active();
        });
        if ($request['search']) {
            $products = $this->productSearch($products, $request);
        }
        return $products->orderBy('id', 'DESC')->get();
    }

    public function getProductsByCategory($request)
    {
        $allCats = $this->getAllSubCategoryIds($request->category_id);
        array_push($allCats, intval($request->category_id));
        $vendorId = $request->vendor_id ?? (!is_null($this->defaultVendor) ? $this->defaultVendor->id : null);

        $optionsValues = isset($request->options_values) && !empty($request->options_values) ? array_values($request->options_values) : [];
        $products = $this->prd->active()
            ->with([
                'offer' => function ($query) {
                    $query->active()->unexpired()->started();
                },
            ])
            ->with(['variants' => function ($q) {
                $q->active();
                $q->with(['offer' => function ($q) {
                    $q->active()->unexpired()->started();
                }]);
            }]);

        $products = $products->whereHas('vendor', function ($query) use ($vendorId) {
            $query->active();
            if (!is_null($vendorId)) {
                $query->where('id', $vendorId);
            }
        });

        if (count($optionsValues) > 0) {
            $products = $products->whereHas('variantValues', function ($query) use ($optionsValues) {
                $query->whereIn('option_value_id', $optionsValues);
            });
        }

        if ($request->category_id) {
            if ($request->category_type == 'home_category') {
                $allCats = (array) $request->category_id;
                $products->whereHas('homeCategories', function ($query) use ($allCats) {
                    $query->whereIn('product_home_categories.home_category_id', $allCats);
                });
            } else { // product_category
                $allCats = $this->getAllSubCategoryIds($request->category_id);
                array_push($allCats, intval($request->category_id));
                $products->whereHas('categories', function ($query) use ($allCats) {
                    $query->whereIn('product_categories.category_id', $allCats);
                });
            }
        }

        if (!is_null($request['is_new'])) {
            $products->where('is_new', $request['is_new'] == 1);
        }

        if ($request['low_price'] && $request['high_price']) {
            $products->whereBetween('price', [$request['low_price'], $request['high_price']]);
        }

        if ($request['search']) {
            $products = $this->productSearch($products, $request);
        }

        if ($request['sort']) {
            $products->when($request['sort'] == 'a_to_z', function ($query) {
                $query->orderBy('title->' . locale(), 'asc');
            });
            $products->when($request['sort'] == 'z_to_a', function ($query) {
                $query->orderBy('title->' . locale(), 'desc');
            });
            $products->when($request['sort'] == 'low_to_high', function ($query) {
                $query->orderBy('price', 'asc');
            });
            $products->when($request['sort'] == 'high_to_low', function ($query) {
                $query->orderBy('price', 'desc');
            });
        } else {
            $products->orderBy('id', 'DESC');
        }

        return $products->paginate(24);
    }

    public function getProductDetails($request, $id)
    {
        $product = $this->prd->active();

        $product = $product->whereHas('vendor', function ($query) {
            $query->active();
            if (!is_null($this->defaultVendor)) {
                $query->where('id', $this->defaultVendor->id);
            }
        });

        $product = $this->returnProductRelations($product, $request);
        return $product->find($id);
    }

    public function getLatestData($request)
    {
        $product = $this->prd->doesnthave('offer')->active();

        $product = $product->whereHas('vendor', function ($query) {
            $query->active();
            if (!is_null($this->defaultVendor)) {
                $query->where('id', $this->defaultVendor->id);
            }
        });

        $product = $this->returnProductRelations($product, $request);

        if ($request['search']) {
            $product = $this->productSearch($product, $request);
        }

        return $product->orderBy('id', 'desc')->take(10)->get();
    }

    public function getOffersData($request, $count = null)
    {
        $product = $this->prd->active();

        $product = $product->whereHas('vendor', function ($query) {
            $query->active();
            if (!is_null($this->defaultVendor)) {
                $query->where('id', $this->defaultVendor->id);
            }
        });

        if ($request->category_id) {
            $allCats = $this->getAllSubCategoryIds($request->category_id) ?? [];
            $product->whereHas('categories', function ($query) use ($allCats) {
                $query->whereIn('product_categories.category_id', $allCats);
            });
        }

        $product = $this->returnProductRelations($product, $request);

        if ($request['search']) {
            $product = $this->productSearch($product, $request);
        }

        $product = $product->whereHas('offer', function ($query) {
            $query->active()->unexpired()->started();
        });

        if (is_null($count)) {
            return $product->paginate(24);
        } else {
            if ($count == 'all') {
                return $product->get();
            } else {
                return $product->take(intval($count))->get();
            }

        }
    }

    public function findOneProduct($id)
    {
        $product = $this->prd->active();

        $product = $product->whereHas('vendor', function ($query) {
            $query->active();
            if (!is_null($this->defaultVendor)) {
                $query->where('id', $this->defaultVendor->id);
            }
        });

        $product = $this->returnProductRelations($product, null);

        return $product->find($id);
    }

    public function findOneProductVariant($id)
    {
        $product = $this->prdVariant->active()->with([
            'offer' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'productValues', 'product',
        ]);

        $product = $product->whereHas('product', function ($query) {
            $query->active();
            $query->whereHas('vendor', function ($query) {
                $query->active();
                if (!is_null($this->defaultVendor)) {
                    $query->where('id', $this->defaultVendor->id);
                }
            });
        });

        return $product->find($id);
    }

    public function getAllSubCategoriesByParent($id)
    {
        return $this->category->where('category_id', $id)->get();
    }

    public function buildCategoriesTree($request)
    {
        $categories = $this->category->active()
            ->withCount(['products' => function ($query) use (&$request) {
                $query->active();
                $query = $this->vendorOfProductQueryCondition($query, $request->state_id, $request->vendor_id);
            }]);

        $categories = $categories->whereHas('products', function ($query) use (&$request) {
            $query->active();
            $query = $this->vendorOfProductQueryCondition($query, $request->state_id, $request->vendor_id);
        });

        $categories = $categories->with(['adverts' => function ($query) use (&$request) {
            $query->active()->unexpired()->started()->orderBy('sort', 'asc');
        }]);

        if ($request->get_main_categories == 'yes') {
            $categories = $categories->mainCategories();
            $categories = $categories->whereHas('childrenRecursive.products', function ($query) use (&$request) {
                $query->active();
                $query = $this->vendorOfProductQueryCondition($query, $request->state_id, $request->vendor_id);
            });
        }

        if ($request->with_products == 'yes') {
            // Get Main Category Products
            $categories = $categories->with([
                'products' => function ($query) use (&$request) {
                    $query->active();
                    $query = $this->returnProductRelations($query, $request);
                    $query = $this->vendorOfProductQueryCondition($query, $request->state_id, $request->vendor_id);
                    if ($request['search']) {
                        $query = $this->productSearch($query, $request);
                    }

                    $query->orderBy('products.sort', 'asc');
                },
            ]);
        }

        return $categories;
    }

    public function productSearch($model, $request)
    {
        $term = strtolower($request['search']);
        return $model->where(function ($query) use ($term) {
            $query->whereRaw('lower(sku) like (?)', ["%{$term}%"]);
            $query->orWhereRaw('lower(title) like (?)', ["%{$term}%"]);
            $query->orWhereRaw('lower(slug) like (?)', ["%{$term}%"]);
        });

        /* ->orWhere(function ($query) use ($request) {
    foreach (config('translatable.locales') as $code) {
    $query->orWhere('title->' . $code, 'like', '%' . $request['search'] . '%');
    $query->orWhere('slug->' . $code, 'like', '%' . $request['search'] . '%');
    }
    }); */
    }

    public function returnProductRelations($model, $request)
    {
        return $model->with([
            'offer' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'options',
            'images',
            'vendor',
            'subCategories',
            'addOns',
            'variants' => function ($q) {
                $q->active();
                $q->with(['offer' => function ($q) {
                    $q->active()->unexpired()->started();
                }]);
            },
        ]);
    }

    public function relatedProducts($selectedProduct)
    {
        $relatedCategoriesIds = $selectedProduct->categories()->pluck('product_categories.category_id')->toArray();
        $products = $this->prd->where('id', '<>', $selectedProduct->id)->active();
        $products = $products->whereHas('categories', function ($query) use ($relatedCategoriesIds) {
            $query->whereIn('product_categories.category_id', $relatedCategoriesIds);
        });
        $products = $products->whereHas('vendor', function ($query) {
            $query->active();
        });
        return $products->orderBy('id', 'desc')->take(10)->get();
    }

    public function getProductsByVendor($id)
    {
        $products = $this->prd->active()->whereHas('vendor', function ($query) use ($id) {
            $query->where('id', $id);
            $query->active();
        });
        $products = $this->returnProductRelations($products, null);
        return $products->orderBy('id', 'DESC')->paginate(24);
    }
}
