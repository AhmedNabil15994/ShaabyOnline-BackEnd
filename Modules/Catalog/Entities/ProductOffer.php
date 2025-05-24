<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class ProductOffer extends Model
{
    use ScopesTrait;

    protected $fillable = ['product_id', 'start_at', 'end_at', 'offer_price', 'status', 'percentage'];

    public function scopeUnexpired($query)
    {
        return $query->where('start_at', '<=', date('Y-m-d'))->where('end_at', '>', date('Y-m-d'));
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
