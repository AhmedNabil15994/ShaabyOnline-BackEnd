<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class UnknownOrderAddress extends Model
{
    public $timestamps = false;
    protected $table = 'unknown_order_address';
    protected $fillable = [
        'order_id', 'state_id', 'receiver_name', 'receiver_mobile',
    ];

    public function state()
    {
        return $this->belongsTo(\Modules\Area\Entities\State::class, 'state_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');

    }

}
