<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderVariantValue extends Model
{
    protected $fillable = ['order_variant_id', 'product_variant_value_id'];


    public function variantValue()
    {
        return $this->belongsTo(\Modules\Variation\Entities\ProductVariantValue::class, 'product_variant_value_id', 'id');
    }
}
