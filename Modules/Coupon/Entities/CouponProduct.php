<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;

class CouponProduct extends Model
{
    protected $fillable = ['coupon_id','product_id'];
}
