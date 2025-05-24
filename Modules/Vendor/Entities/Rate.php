<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;
use Modules\Order\Entities\Order;

class Rate extends Model
{
    use ScopesTrait;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class);
    }

    public function vendor()
    {
        return $this->belongsTo(\Modules\Vendor\Entities\Vendor::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
