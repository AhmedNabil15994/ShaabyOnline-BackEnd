<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class DeliveryCharge extends Model
{
    use HasTranslations;

    protected $guarded = ['id'];
    public $translatable = ['delivery_time'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('delivery');
    }

    public function scopeFilterState($query, $state_id)
    {
        $query->where('state_id', $state_id);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
