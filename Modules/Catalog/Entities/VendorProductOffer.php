<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class VendorProductOffer extends Model
{
    use ScopesTrait;

    protected $fillable = ['vendor_product_id', 'start_at', 'end_at', 'offer_price', 'status', 'percentage'];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeUnexpired($query)
    {
        return $query->where('start_at', '<=', date('Y-m-d'))->where('end_at', '>', date('Y-m-d'));
    }

}
