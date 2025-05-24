<?php

namespace Modules\Catalog\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Modules\Core\Traits\HasSlugTranslation;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeCategory extends Model
{
    use HasTranslations, SoftDeletes, ScopesTrait;
    use HasSlugTranslation;
    protected $guarded = ["id"];
    public $translatable = ['title', 'slug'];

    public function products()
    {
        $request =  request();
        $base = $this->belongsToMany(
            Product::class,
            'product_home_categories',
            "home_category_id",
            "product_id"
        );
        if ($request->c_vendor_id) {
            $base->active()->where("products.vendor_id", $request->c_vendor_id);
        }

        return $base;
    }
}
