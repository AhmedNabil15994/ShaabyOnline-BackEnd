<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Advertising\Entities\Advertising;
use Modules\Core\Traits\ScopesTrait;
use Modules\Notification\Entities\GeneralNotification;
use Modules\Order\Entities\OrderProduct;
use Modules\Slider\Entities\Slider;
use Modules\Tags\Entities\Tag;
use Modules\Variation\Entities\Option;

use Spatie\Translatable\HasTranslations;
use Modules\Core\Traits\HasSlugTranslation;

class Product extends Model
{
    use HasSlugTranslation;
    use HasTranslations, SoftDeletes, ScopesTrait;

    protected $with = [];
    protected $guarded = ["id"];
    protected $casts = [
        "shipment" => "array"
    ];
    public $translatable = [
        'title', 'short_description', 'description', 'slug', 'seo_description', 'seo_keywords'
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    // START - Override active scope to add `pending_for_approval`
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at')->where('status', true)->where('pending_for_approval', true);
    }

    // END - Override active scope to add `pending_for_approval`

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function subCategories()
    {
        return $this->belongsToMany(Category::class, 'product_categories')
            ->whereNotNull('categories.category_id');
    }

    public function parentCategories()
    {
        return $this->belongsToMany(Category::class, 'product_categories')
            ->whereNull('categories.category_id');
    }

    public function homeCategories()
    {
        return $this->belongsToMany(
            HomeCategory::class,
            'product_home_categories',
            "product_id",
            "home_category_id"
        )->withTimestamps();
    }

    public function offer()
    {
        return $this->hasOne(ProductOffer::class, 'product_id');
    }

    public function vendor()
    {
        return $this->belongsTo(\Modules\Vendor\Entities\Vendor::class);
    }

    public function addOns()
    {
        return $this->hasMany(ProductAddon::class, 'product_id');
    }

    // variations
    public function options()
    {
        return $this->hasMany(\Modules\Variation\Entities\ProductOption::class);
    }

    public function productOptions()
    {
        return $this->belongsToMany(Option::class, 'product_options');
    }

    public function variants()
    {
        return $this->hasMany(\Modules\Variation\Entities\ProductVariant::class);
    }

    public function variantChosed()
    {
        return $this->hasOne(\Modules\Variation\Entities\ProductVariant::class);
    }

    public function variantValues()
    {
        return $this->hasMany(\Modules\Variation\Entities\ProductVariantValue::class);
    }

    public function checkIfHaveOption($optionId)
    {
        return $this->variantValues->contains('option_value_id', $optionId);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }

    public function adverts()
    {
        return $this->morphMany(Advertising::class, 'advertable');
    }

    public function generalNotifications()
    {
        return $this->morphMany(GeneralNotification::class, 'notifiable');
    }

    public function sliders()
    {
        return $this->morphMany(Slider::class, 'sliderable');
    }

    /**
     * Get all of the search keywords for the product.
     */
    public function searchKeywords()
    {
        return $this->morphToMany(SearchKeyword::class, 'searchable');
    }
}
