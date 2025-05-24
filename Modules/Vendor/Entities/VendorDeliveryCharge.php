<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;
use Spatie\Translatable\HasTranslations;

class VendorDeliveryCharge extends Model
{
    use ScopesTrait, HasTranslations;

    protected $guarded = ['id'];
    public $translatable = ['delivery_time'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)->whereNotNull('delivery');
    }

    public function scopeFilterState($query, $state_id)
    {
        $query->where('state_id', $state_id);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

}
