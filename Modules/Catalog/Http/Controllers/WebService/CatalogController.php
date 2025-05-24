<?php

namespace Modules\Catalog\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Modules\Advertising\Transformers\WebService\AdvertisingGroupResource;
use Modules\Catalog\Transformers\WebService\AutoCompleteProductResource;
use Modules\Catalog\Transformers\WebService\FilteredOptionsResource;
use Modules\Catalog\Transformers\WebService\PaginatedResource;
use Modules\Catalog\Transformers\WebService\ProductResource;
use Modules\Catalog\Transformers\WebService\CategoryResource;
use Modules\Catalog\Repositories\WebService\CatalogRepository as Catalog;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Slider\Repositories\WebService\SliderRepository as Slider;
use Modules\Advertising\Repositories\WebService\AdvertisingRepository as Advertising;
use Modules\Slider\Transformers\WebService\SliderResource;
use Illuminate\Http\JsonResponse;
use Modules\Catalog\Transformers\WebService\UnlimitedCategoryResource;
use Modules\Catalog\Repositories\WebService\HomeCategoryRepository;
use Modules\Catalog\Transformers\WebService\HomeCategoryResource;

class CatalogController extends WebServiceController
{
    protected $catalog;
    protected $slider;
    protected $advert;
    protected $homeCategory;

    function __construct(Catalog $catalog, Slider $slider, Advertising $advert, HomeCategoryRepository $homeCategory)
    {
        $this->catalog = $catalog;
        $this->slider = $slider;
        $this->advert = $advert;
        $this->homeCategory = $homeCategory;
    }

    public function getHomeData(Request $request): JsonResponse
    {
        // Get Slider Data
        $sliders = $this->slider->getRandomPerRequest();
        $result['slider'] = SliderResource::collection($sliders);

        /*
        // Get Featured Products
        $newData = $this->catalog->getFeaturedProducts($request);
        $result['featured_products'] = ProductResource::collection($newData);

        // Get Offers Products
        $bundleOffers = $this->catalog->getOffersData($request);
        $result['offers_products'] = ProductResource::collection($bundleOffers);
        */

        if ($request->with_home_category == 'yes') {
            $result['categories'] = HomeCategoryResource::collection($this->homeCategory->list($request));
        } else {
            // Get Latest N Categories
            $categories = $this->catalog->getLatestNCategories($request);
            $result['categories'] = CategoryResource::collection($categories);
        }

        $adverts = $this->advert->getAdvertGroups();
        $result['advertsGroups'] = AdvertisingGroupResource::collection($adverts);

        return $this->response($result);
    }

    public function getAllCategories(Request $request): JsonResponse
    {
        $categories = $this->catalog->getAllCategories($request);
        return $this->response(CategoryResource::collection($categories));
    }

    public function getAutoCompleteProducts(Request $request)
    {
        $products = $this->catalog->getAutoCompleteProducts($request);
        $result = AutoCompleteProductResource::collection($products);
        return $this->response($result);
    }

    public function getProductsByCategory(Request $request)
    {
        if ($request->category_type == 'home_category') {
            $result['main_categories'] = HomeCategoryResource::collection($this->homeCategory->list($request));
        } else {
            $categories = $this->catalog->getAllMainCategories($request);
            $result['main_categories'] = CategoryResource::collection($categories);
        }

        $options = $this->catalog->getFilterOptions($request);
        $result['options'] = FilteredOptionsResource::collection($options);

        $products = $this->catalog->getProductsByCategory($request);
        $result['products'] = PaginatedResource::make($products)->mapInto(ProductResource::class);

        return $this->response($result);
    }

    public function getOffersData(Request $request)
    {
        $withRelations = ['childrenRecursive'];
        $categories = $this->catalog->getAllMainCategories($request, $withRelations);
        $result['categories'] = UnlimitedCategoryResource::collection($categories);

        $products = $this->catalog->getOffersData($request);
        $result['products'] = PaginatedResource::make($products)->mapInto(ProductResource::class);

        return $this->response($result);
    }

    public function getProductDetails(Request $request, $id): JsonResponse
    {
        $product = $this->catalog->getProductDetails($request, $id);
        if ($product) {
            $result = [
                'product' => new ProductResource($product),
                'related_products' => ProductResource::collection($this->catalog->relatedProducts($product)),
            ];
            return $this->response($result);
        } else
            return $this->response(null);
    }
}
