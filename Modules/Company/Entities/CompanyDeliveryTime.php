<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;

class CompanyDeliveryTime extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        "custom_times" => "array"
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
