<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Advertising\Entities\Advertising;
use Modules\Core\Traits\HasSlugTranslation;
use Modules\Core\Traits\ScopesTrait;
use Modules\Notification\Entities\GeneralNotification;
use Modules\Slider\Entities\Slider;
use Spatie\Translatable\HasTranslations;

class VendorCategory extends Model
{
    use HasSlugTranslation, HasTranslations, SoftDeletes, ScopesTrait;

    protected $with = ['children'];
    protected $guarded = ['id'];
    public $translatable = [
        'title', 'slug'
    ];

    public function scopeMainCategories($query)
    {
        return $query->whereNull('vendor_category_id');
    }

    public function parent()
    {
        return $this->belongsTo(VendorCategory::class, 'vendor_category_id');
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_categories_pivot')->withTimestamps();
    }

    public function getParentsAttribute()
    {
        $parents = collect([]);
        $parent = $this->parent;
        while (!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }
        return $parents;
    }

    public function children()
    {
        $categories = $this->hasMany(VendorCategory::class, 'vendor_category_id');
        if (!is_null(request()->route()) && in_array(request()->route()->getName(), ['api.home', 'frontend.home'])) {
            $categories = $categories->where('show_in_home', 1);
        }

        if (!is_null(request()->route()) && !request()->is(locale() . '/dashboard/*')) {
            $categories = $categories->whereHas('vendors', function ($query) {
                $query->active();
            });
        }

        // Get Child Category vendors
        $categories = $categories->with([
            'vendors' => function ($query) {
                $query->active();
                $query->orderBy('id', 'DESC');
            },
        ]);
        return $categories;
    }

    public function childrenRecursive()
    {
        return $this->children()->active()->with('childrenRecursive');
    }

    public function subCategories()
    {
        return $this->hasMany(VendorCategory::class, 'vendor_category_id')
            ->has('vendors')
            ->whereNotNull('vendor_categories.vendor_category_id');
    }

    public function getAllRecursiveChildren()
    {
        $category = new Collection();
        foreach ($this->children as $cat) {
            $category->push($cat);
            $category = $category->merge($cat->getAllRecursiveChildren());
        }
        return $category;
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
}
