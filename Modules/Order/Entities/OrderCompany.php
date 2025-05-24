<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderCompany extends Model
{
    public $timestamps = false;
    protected $fillable = ['order_id', 'vendor_id', 'company_id', 'availabilities', 'delivery'];

    /*protected $casts = [
        "availabilities" => "array",
        "delivery" => "array",
    ];*/

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function company()
    {
        return $this->belongsTo(\Modules\Company\Entities\Company::class);
    }
}
