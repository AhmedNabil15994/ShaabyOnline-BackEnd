<?php

namespace Modules\Area\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

use Spatie\Translatable\HasTranslations;
use Modules\Core\Traits\HasSlugTranslation;

class Country extends Model
{
    use HasSlugTranslation;
    use HasTranslations, SoftDeletes, ScopesTrait;

    protected $with = [];
    protected $fillable 					= ["status","code","title","slug"];
    public $translatable = ['title', 'slug'];

    public function cities()
    {
        return $this->hasMany(City::class, 'country_id');
    }

    public function states()
    {
        return $this->hasManyThrough(State::class, City::class);
    }
}
