<?php

namespace Modules\Apps\Entities;

use Carbon\Carbon;
use Modules\Catalog\Entities\Brand;
use Modules\Catalog\Entities\Category;
use Modules\Catalog\Entities\Product;
use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Advertising\Entities\AdvertisingGroup;
use Modules\Vendor\Entities\Vendor;

class AppHome extends Model
{
    use HasTranslations, SoftDeletes, ScopesTrait;

    const TYPES = [
        'products',
        'sliders',
        'categories',
        'description',
        'vendors',
    ];
    protected $table = 'app_homes';
    protected $fillable = ["short_title", "title", "description", "type", 'order', 'start_at', 'end_at', 'status', 'display_type', 'grid_columns_count'];
    public $translatable = ['title', 'short_title', 'description'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'homable', 'homables');
    }

    public function sliders()
    {
        return $this->morphedByMany(AdvertisingGroup::class, 'homable', 'homables');
    }

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'homable', 'homables');
    }

    public function vendors()
    {
        return $this->morphedByMany(Vendor::class, 'homable', 'homables');
    }

    public function brand()
    {
        return $this->morphedByMany(Brand::class, 'homable', 'homables');
    }

    static function typesForSelect($display_name_type = 'slider_type')
    {
        $array = [];
        foreach (self::TYPES as $type) {
            $array[$type] = __('apps::dashboard.app_homes.form.' . $display_name_type . '.' . $type);
        }

        return $array;
    }

    static function getClassByType($type)
    {

        switch ($type) {
            case 'products':
                return new Product();
            case 'sliders':
                return new AdvertisingGroup();
            case 'categories':
                return new Category();
            case 'brand':
                return new Brand();
            case 'vendors':
                return new Vendor();
        }
    }

    static function getClassNameByType($type)
    {

        switch ($type) {
            case 'products':
                return 'products';
            case 'sliders':
                return 'sliders';
            case 'brand':
                return 'brands';
            case 'vendors':
                return 'vendors';
        }
    }


    public function scopePublished($query)
    {

        return $query->where(function ($q) {
            $q->where(function ($q) {

                $q->whereDate('start_at', '<=', Carbon::now())
                    ->orWhereNull('start_at');
            })->where(function ($q) {

                $q->whereDate('end_at', '>=', Carbon::now())
                    ->orWhereNull('end_at');
            });
        });
    }
}
