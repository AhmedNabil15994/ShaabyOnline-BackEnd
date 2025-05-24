<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\Model;

class VendorWorkTime extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        "custom_times" => "array"
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

}
