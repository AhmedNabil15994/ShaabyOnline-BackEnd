<?php

namespace Modules\Variation\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductVariantValue extends Model
{
    protected $fillable = ['option_value_id', 'product_id', 'product_variant_id', 'product_option_id'];

    public function product()
    {
        return $this->belongsTo(\Modules\Catalog\Entities\Product::class);
    }

    public function productOption()
    {
        return $this->belongsTo(ProductOption::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function optionValue()
    {
        return $this->belongsTo(OptionValue::class);
    }
}
