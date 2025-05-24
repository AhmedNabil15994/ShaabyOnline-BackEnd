<?php

namespace Modules\Variation\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class ProductVariant extends Model
{
    use ScopesTrait;

    protected $fillable = ['product_id', 'sku', 'price', 'status', 'qty', 'image', "shipment"];
    protected $casts = [
        "shipment" => "array"
    ];

    public function productValues()
    {
        return $this->hasMany(ProductVariantValue::class);
    }

    public function product()
    {
        return $this->belongsTo(\Modules\Catalog\Entities\Product::class);
    }

    public function offer()
    {
        return $this->hasOne(VariationOffer::class, 'product_variant_id');
    }
}
