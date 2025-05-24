<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Wrapping\Entities\Gift;

class OrderGift extends Model
{
    public $timestamps = false;
    protected $fillable = ['order_id', 'gift_id', 'products_ids', 'price'];

    protected $casts = [
        "products_ids" => "array"
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function gift()
    {
        return $this->belongsTo(Gift::class, 'gift_id');
    }
}
