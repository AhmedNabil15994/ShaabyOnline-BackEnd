<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Wrapping\Entities\Card;

class OrderCard extends Model
{
    public $timestamps = false;
    protected $fillable = ['order_id', 'card_id', 'price', 'sender_name', 'receiver_name', 'message'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
}
