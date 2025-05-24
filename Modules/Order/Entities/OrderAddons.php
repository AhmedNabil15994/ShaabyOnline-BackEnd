<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Wrapping\Entities\WrappingAddons;

class OrderAddons extends Model
{
    public $timestamps = false;
    protected $fillable = ['order_id', 'addons_id', 'price', 'qty'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function addons()
    {
        return $this->belongsTo(WrappingAddons::class, 'addons_id');
    }
}
