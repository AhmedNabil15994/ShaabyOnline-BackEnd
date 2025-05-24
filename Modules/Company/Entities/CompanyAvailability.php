<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;

class CompanyAvailability extends Model
{
    protected $fillable = [
        'company_id', 'day_code', 'status', 'is_full_day', 'custom_times',
    ];

    protected $casts = [
        "custom_times" => "array"
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

}
