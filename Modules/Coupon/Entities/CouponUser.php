<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    protected $fillable = ['coupon_id','user_id'];
}
