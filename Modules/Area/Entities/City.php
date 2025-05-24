<?php

namespace Modules\Area\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

use Modules\Core\Traits\HasSlugTranslation;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model 
{
  	use HasTranslations , SoftDeletes , ScopesTrait;
    use HasSlugTranslation;

    protected $with 					    = [];
	  protected $fillable 					= ["status","country_id","title","slug"];
  	public $translatable 	= [ 'title' , 'slug' ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
