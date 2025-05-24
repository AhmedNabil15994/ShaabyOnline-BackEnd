<?php

namespace Modules\Variation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Catalog\Entities\Product;
use Modules\Core\Traits\ScopesTrait;
use Spatie\Translatable\HasTranslations;

class Option extends Model
{
    use HasTranslations, SoftDeletes, ScopesTrait;

    protected $with = [];
    protected $guarded = ["id"];
    public $translatable = ['title', 'notes'];

    public function scopeActiveInFilter($query)
    {
        return $query->where('option_as_filter', true);
    }

    public function scopeUnActiveInFilter($query)
    {
        return $query->where('option_as_filter', false);
    }

    public function values()
    {
        return $this->hasMany(OptionValue::class);
    }

    public function productOptions()
    {
        return $this->belongsToMany(Product::class, 'product_options');
    }

}
