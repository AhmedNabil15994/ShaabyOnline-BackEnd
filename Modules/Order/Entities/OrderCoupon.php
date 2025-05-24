<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Coupon\Entities\Coupon;

class OrderCoupon extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['products' => 'array'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

}
