<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Variation\Entities\ProductVariantValue;

class OrderVariantProductValue extends Model
{
    protected $fillable = [
        'order_variant_product_id',
        'product_variant_value_id',
    ];

    public function productVariantValue()
    {
        return $this->belongsTo(ProductVariantValue::class);
    }

}
