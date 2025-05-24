<?php

namespace Modules\Catalog\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vendor\Repositories\FrontEnd\VendorRepository as Vendor;
use Modules\Catalog\Repositories\FrontEnd\BrandRepository as Brand;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;
use Modules\Catalog\Repositories\FrontEnd\CategoryRepository as Category;

class FilterController extends Controller
{

    function __construct(Vendor $vendor,Product $product,Category $category,Brand $brand)
    {
        $this->product  = $product;
        $this->vendor   = $vendor;
        $this->category = $category;
        $this->brand    = $brand;
    }

    public function index(Request $request,$slug)
    {
        $vendor  = $this->vendor->findByslug($slug);

        if(!$vendor)
            abort(404);


        $productsList =  $this->product->filterProducts($request,$slug);
        $categories   = $this->category->mainCategoriesOfVendorProducts($vendor);
        $brands       = $this->brand->getAllActiveByVendor($vendor);
        $rangePrice   = $this->product->rangePrice($vendor);

        if ($this->vendor->checkRouteLocale($vendor,$slug)){
          return view('vendor::frontend.vendors.index',
                 compact('vendor','productsList','categories','brands','rangePrice')
               );
        }

        return view('catalog::frontend.filters.index',compact('vendor','productsList'));
    }
}
