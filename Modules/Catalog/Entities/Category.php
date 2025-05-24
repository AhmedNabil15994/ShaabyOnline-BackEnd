<?php

namespace Modules\Catalog\Entities;

use Illuminate\Support\Collection;
use Modules\Slider\Entities\Slider;
use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Occasion\Entities\Occasion;
use Spatie\Translatable\HasTranslations;
use Modules\Core\Traits\HasSlugTranslation;
use Illuminate\Database\Eloquent\SoftDeletes;

use Modules\Advertising\Entities\Advertising;
use Modules\Core\Traits\CoreTrait;
use Modules\Notification\Entities\GeneralNotification;

class Category extends Model
{
    use HasTranslations, SoftDeletes, ScopesTrait;
    use HasSlugTranslation;
    use CoreTrait;

    protected $with = ['children'];
    public $sluggable = 'title';
    protected $guarded = ["id"];
    public $translatable = ['title', 'slug', 'seo_description', 'seo_keywords'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories');
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

    public function occasions()
    {
        return $this->hasMany(Occasion::class, 'category_id');
    }

    /* public function children()
    {
        $vendor = app('vendorObject') ?? null;

        $categories = $this->hasMany(Category::class, 'category_id')->withCount(['products' => function ($q) use ($vendor) {
            $q->active();
            if (!is_null($vendor)) {
                $q->where('vendor_id', $vendor->id);
            }
        }]);

        if (!is_null(request()->route()) && in_array(request()->route()->getName(), ['api.home', 'frontend.home'])) {
            $categories = $categories->where('show_in_home', 1);
        }

        if (!is_null(request()->route()) && request()->segment(2) != 'dashboard') {
            $categories = $categories->has('products');
            // Get Child Category Products
            $categories = $categories->with([
                'products' => function ($query) use ($vendor) {
                    $query->active()
                        ->with([
                            'offer' => function ($query) {
                                $query->active()->unexpired()->started();
                            },
                            'options',
                            'images',
                            'vendor',
                            'variants' => function ($q) {
                                $q->with(['offer' => function ($q) {
                                    $q->active()->unexpired()->started();
                                }]);
                            },
                        ]);
                    if (!is_null($vendor)) {
                        $query->where('vendor_id', $vendor->id);
                    }
                    $query->orderBy('id', 'DESC');
                },
            ]);
        }

        return $categories;
    } */

    public function children()
    {
        $categories = $this->hasMany(Category::class, 'category_id');
        if (!is_null(request()->route()) && in_array(request()->route()->getName(), ['api.home', 'frontend.home'])) {
            $categories = $categories->where('show_in_home', 1);
        }

        if (request()->get('vendor_id')) {
            $request = request()->query();
            $categories = $categories->with(['products' => function ($query) use (&$request) {
                $query->active();
                $query = $this->vendorOfProductQueryCondition($query, $request['state_id'] ?? null, $request['vendor_id']);
            }]);
            $categories = $categories->whereHas('products', function ($query) use (&$request) {
                $query->active();
                $query = $this->vendorOfProductQueryCondition($query, $request['state_id'] ?? null, $request['vendor_id']);
            });
        }

        return $categories;
    }

    public function childrenRecursive()
    {
        return $this->children()->active()->with('childrenRecursive');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'category_id')
            ->has('products')
            ->whereNotNull('categories.category_id');
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
