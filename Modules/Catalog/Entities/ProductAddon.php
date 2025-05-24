<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class ProductAddon extends Model
{
    use ScopesTrait;

    protected $table = 'product_addons';
    protected $guarded = ["id"];
    protected $with = ['addonCategory', 'addonOptions'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function addonCategory()
    {
        return $this->belongsTo(AddonCategory::class, 'addon_category_id');
    }

    public function addonOptions()
    {
        return $this->hasMany(ProductAddonOption::class, 'product_addon_id');
    }

}
