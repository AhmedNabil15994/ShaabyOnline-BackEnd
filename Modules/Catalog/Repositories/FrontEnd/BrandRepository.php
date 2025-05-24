<?php

namespace Modules\Catalog\Repositories\FrontEnd;

use Modules\Catalog\Entities\Brand;
use Hash;
use DB;

class BrandRepository
{

    function __construct(Brand $brand)
    {
        $this->brand   = $brand;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $brands = $this->brand->orderBy($order, $sort)->get();
        return $brands;
    }

    public function getAllActiveByVendor($vendor,$order = 'id', $sort = 'desc')
    {
        $brands = $this->brand->active()
                  ->whereHas('products', function($query) use($vendor){

                    $query->whereHas('vendor', function($query) use($vendor) {

                        $query->where('vendor_id' , $vendor->id);

                    });

                })->orderBy($order, $sort)->get();

        return $brands;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $brands = $this->brand->active()->orderBy($order, $sort)->get();
        return $brands;
    }

}
