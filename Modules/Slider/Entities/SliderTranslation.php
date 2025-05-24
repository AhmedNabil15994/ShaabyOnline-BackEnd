<?php

namespace Modules\Slider\Entities;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class SliderTranslation extends Model
{
    use HasSlug;

    public $timestamps = false;
    protected $fillable = [
        'title', 'short_description', 'slug',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
