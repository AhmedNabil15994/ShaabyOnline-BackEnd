<?php

namespace Modules\Advertising\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Modules\Core\Traits\HasSlugTranslation;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Advertising\Entities\Advertising;

class AdvertisingGroup extends Model
{
    use HasTranslations, SoftDeletes, ScopesTrait;
    use HasSlugTranslation;

    protected $with = [];
    protected $table = 'advertising_groups';
    protected $fillable = ["position", "sort", "status", "title", "slug"];
    protected $translationForeignKey = 'ad_group_id';

    public $translatable = [
        'title', 'slug',
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function adverts()
    {
        return $this->hasMany(Advertising::class, 'ad_group_id');
    }

    public function getPositionAttribute($value)
    {
        switch ($value) {
            case "home":
                return __('advertising::dashboard.advertising_groups.form.home');
            case "categories":
                return __('advertising::dashboard.advertising_groups.form.categories');
            default:
                return null;
        }
    }
}
