<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    protected $fillable = ['flag', 'color'];
}
