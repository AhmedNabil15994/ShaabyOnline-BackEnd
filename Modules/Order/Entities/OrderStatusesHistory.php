<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class OrderStatusesHistory extends Model
{
    protected $table = 'order_statuses_history';
    protected $fillable = ['order_id', 'order_status_id', 'user_id'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
