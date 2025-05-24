<?php

namespace Modules\Catalog\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

use Modules\Core\Traits\HasSlugTranslation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasTranslations , SoftDeletes , ScopesTrait;
    use HasSlugTranslation;

    protected $with 					    = [];
    protected $fillable 					= ["status","image","blogable_type","blogable_id","title","slug","seo_description","seo_keywords"];
    public $translatable 	= [ 'title' , 'slug' , 'seo_description' , 'seo_keywords'];
    public $sluggable = 'title';
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
