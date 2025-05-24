<?php

namespace Modules\Catalog\Repositories\FrontEnd;

use Modules\Catalog\Entities\Product;
use Illuminate\Support\Arr;
use DB;
use Modules\Variation\Entities\Option;
use Modules\Variation\Entities\OptionValue;
use Modules\Variation\Entities\ProductVariant;
use Modules\Variation\Entities\ProductVariantValue;

class ProductRepository
{
    protected $product;
    protected $variantPrd;
    protected $variantPrdValue;
    protected $option;
    protected $optionValue;
    protected $defaultVendor;

    public function __construct(Product $product, ProductVariant $variantPrd, ProductVariantValue $variantPrdValue, Option $option, OptionValue $optionValue)
    {
        $this->product = $product;
        $this->variantPrd = $variantPrd;
        $this->variantPrdValue = $variantPrdValue;
        $this->option = $option;
        $this->optionValue = $optionValue;

        $this->defaultVendor = app('vendorObject') ?? null;
    }

    public function findBySlug($slug)
    {
        $product = $this->product->active()
            ->with([
                "vendor",
                "categories",
                "images",
                "tags",
                "options.option",
                'offer' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'addOns'
            ]);

        $product = $product->whereHas('vendor', function ($query) {
            $query->active();
            if (!is_null($this->defaultVendor)) {
                $query->where('id', $this->defaultVendor->id);
            }
        });


        $product = $product->anyTranslation('slug', $slug)->first();
        return $product;
    }

    public function checkRouteLocale($model, $slug)
    {
        // if ($model->translate()->where('slug', $slug)->first()->locale != locale())
        //     return false;
        if ($array = $model->getTranslations("slug")) {
            $locale = array_search($slug, $array);

            return $locale == locale();
        }
        return true;
    }

    public function getProductsByCategory($request, $category, $with = [])
    {
        $products = $this->product->orderBy('id', 'desc')->active()
            ->with(['offer' => function ($query) {
                $query->active()->unexpired()->started();
            }]);

        $products = $products->whereHas('vendor', function ($query) use ($request) {
            $query->active();
            if (!is_null($request->vendor)) {
                $query->anyTranslation('slug', $request->vendor);
            } elseif (!is_null($this->defaultVendor)) {
                $query->where('id', $this->defaultVendor->id);
            }
        });


        $products = $products->whereHas('categories', function ($query) use ($request, $category) {
            if (!empty($request->categories)) {
                $query->whereIn('product_categories.category_id', array_keys($request->categories));
            } elseif ($category != null) {
                $query->where('product_categories.category_id', $category->id);
            }
        });


        if (isset($request->s) && !empty($request->s)) {
            $products = $products->where(function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->s . '%');
                    $query->orWhere('slug', 'like', '%' . $request->s . '%');
                })->orWhereHas('searchKeywords', function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->s . '%');
                });
            });
        }

        if (!empty($request->tags)) {
            $products = $products->whereHas('tags', function ($query) use ($request) {
                $query->anyTranslation('slug', $request->tags);
            });
        }
        if ($request['price_from'] && $request['price_to']) {
            $products = $products->whereBetween('price', [$request['price_from'], $request['price_to']]);
        }

        $products = $products->with($with)->paginate(config('core.config.products_pagination_count'));

        return $products;
    }

    public function getRelatedProducts($product, $categories, $with = [])
    {
        $products = $this->product->orderBy('id', 'desc')->active()
            ->with(['offer' => function ($query) {
                $query->active()->unexpired()->started();
            }])
            ->with($with)
            ->where('id', '<>', $product->id)
            ->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('product_categories.category_id', $categories);
            });

        $products = $products->whereHas('vendor', function ($query) {
            $query->active();
            if (!is_null($this->defaultVendor)) {
                $query->where('id', $this->defaultVendor->id);
            }
        });

        $products = $products->get();

        return $products;
    }

    public function findOneProduct($id)
    {
        $product = $this->product->active();

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
        $product = $this->variantPrd->active()->with([
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

    public function findById($id)
    {
        $product = $this->product->withDeleted()
            ->with([
                'tags', 'images',
                'addOns' => function ($q) {
                    $q->with('addOnOptions');
                },
                'options.option' => function ($q) {
                    $q->active()->with(['values' => function ($query) {
                        $query->active();
                    }]);
                }
            ]);

        $product = $product->whereHas('vendor', function ($query) {
            $query->active();
            if (!is_null($this->defaultVendor)) {
                $query->where('id', $this->defaultVendor->id);
            }
        });

        return $product->find($id);
    }

    public function findVariantProductById($id)
    {
        $product = $this->variantPrd->with(['product', 'offer', 'productValues' => function ($q) {
            $q->with(['optionValue', 'productOption' => function ($q) {
                $q->with('option');
            }]);
        }]);

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

    public function getVariantProductsByPrdId($id)
    {
        $products = $this->variantPrd->with(['offer', 'productValues' => function ($q) {
            $q->with(['optionValue', 'productOption' => function ($q) {
                $q->with('option');
            }]);
        }])->where('product_id', $id);

        $products = $products->whereHas('product', function ($query) {
            $query->active();
            $query->whereHas('vendor', function ($query) {
                $query->active();
                if (!is_null($this->defaultVendor)) {
                    $query->where('id', $this->defaultVendor->id);
                }
            });
        });

        return $products->get();
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
                $q->with(['offer' => function ($q) {
                    $q->active()->unexpired()->started();
                }]);
            },
        ]);
    }

    public function autoCompleteSearch($request)
    {
        $term = strtolower($request->input('query'));
        return $this->product->active()
            ->whereHas('vendor', function ($query) {
                $query->active();
            })
            ->where(function ($query) use ($term) {
                $query->whereRaw('lower(sku) like (?)', ["%{$term}%"]);
                $query->orWhereRaw('lower(title) like (?)', ["%{$term}%"]);
                $query->orWhereRaw('lower(slug) like (?)', ["%{$term}%"]);
            });
    }
}
