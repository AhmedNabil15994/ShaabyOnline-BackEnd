<?php

namespace Modules\Variation\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $fillable = ['product_id','option_id'];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function product()
    {
        return $this->belongsTo(\Modules\Catalog\Entities\Product::class);
    }

    public function productValues()
    {
        return $this->hasMany(ProductVariantValue::class);
    }
}
