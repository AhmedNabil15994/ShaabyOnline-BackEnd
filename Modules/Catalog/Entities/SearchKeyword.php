<?php

namespace Modules\Catalog\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class SearchKeyword extends Model
{
    use SoftDeletes, ScopesTrait;

    public $table = 'search_keywords';
    protected $guarded = ['id'];

    /**
     * Get all of the products that are assigned this search keywords.
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'searchable');
    }


}
