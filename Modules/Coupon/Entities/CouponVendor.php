<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;

class CouponVendor extends Model
{
    protected $fillable = ['coupon_id','vendor_id'];
}
