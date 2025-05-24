<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

use Spatie\Translatable\HasTranslations;
use Modules\Core\Traits\HasSlugTranslation;

class Page extends Model
{
    use HasSlugTranslation;
    use HasTranslations, SoftDeletes, ScopesTrait;

    protected $fillable = ["status", "type", "page_id", "description", "title", "slug", "seo_description", "seo_keywords"];
    public $translatable = ['description', 'title', 'slug', 'seo_description', 'seo_keywords'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
