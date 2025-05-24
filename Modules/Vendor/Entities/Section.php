<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

use Spatie\Translatable\HasTranslations;
use Modules\Core\Traits\HasSlugTranslation;

class Section extends Model
{
    use HasSlugTranslation;
    use HasTranslations, SoftDeletes, ScopesTrait;

    protected $with = [];
    protected $guarded = ["id"];
    public $translatable = ['description', 'title', 'slug', 'seo_description', 'seo_keywords'];

    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'section_id');
    }

    /* public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_sections');
    } */
}
