<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\ScopesTrait;
use Modules\Vendor\Entities\Vendor;

use Spatie\Translatable\HasTranslations;
use Modules\Core\Traits\HasSlugTranslation;

class Company extends Model
{
    use HasSlugTranslation;
    use HasTranslations, SoftDeletes, ScopesTrait;

    protected $sluggable = "name";
    protected $with = [];

    protected $guarded = ["id"];
    public $translatable = [
        'name', 'description', "slug", 'direct_delivery_message',
    ];
    protected $casts = [
        'delivery_time_types' => 'array',
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function deliveryCharge()
    {
        return $this->hasMany(DeliveryCharge::class, 'company_id');
    }

    public function drivers()
    {
        return $this->hasMany(\Modules\User\Entities\User::class, 'company_id');
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_companies');
    }

    public function availabilities()
    {
        return $this->hasMany(CompanyAvailability::class, 'company_id');
    }

    public function deliveryTimes()
    {
        return $this->hasMany(CompanyDeliveryTime::class, 'company_id');
    }
}
