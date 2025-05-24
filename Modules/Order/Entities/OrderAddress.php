<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $guarded = ['id'];

    public function state()
    {
        return $this->belongsTo(\Modules\Area\Entities\State::class);
    }
}
