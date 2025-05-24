<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderVendor extends Model
{
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function vendor()
    {
        return $this->belongsTo(\Modules\Vendor\Entities\Vendor::class);
    }

}
