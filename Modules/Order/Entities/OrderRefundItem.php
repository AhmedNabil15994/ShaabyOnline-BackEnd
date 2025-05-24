<?php

namespace Modules\Order\Entities;

use Kirschbaum\PowerJoins\PowerJoins;
use Illuminate\Database\Eloquent\Model;

class OrderRefundItem extends Model
{
    use PowerJoins;
    protected $guarded = ["id"];

    public  function item()
    {
        # code...
        return $this->morphTo();
    }

    public function scopeOrderProduct($query)
    {
        return $query->where("item_type", \Modules\Order\Entities\OrderProduct::class);
    }
    public function scopeOrderVariantProduct($query)
    {
        return $query->where("item_type", \Modules\Order\Entities\OrderVariantProduct::class);
    }
}
