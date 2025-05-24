<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'product_id', 'image'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
