<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class VendorProduct extends Model
{
    use ScopesTrait;

  	protected $fillable = [
      'sku' ,'qty' , 'vendor_id' , 'price' , 'status' , 'product_id'
    ];

    public function mainProduct()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo(\Modules\Vendor\Entities\Vendor::class);
    }

    public function offer()
    {
        return $this->hasOne(VendorProductOffer::class);
    }
}
