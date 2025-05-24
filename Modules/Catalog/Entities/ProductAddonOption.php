<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class ProductAddonOption extends Model
{
    use ScopesTrait;

    protected $table = 'product_addon_options';
    protected $guarded = ["id"];
    public $timestamps = false;
    protected $with = ['addonOption'];

    public function productAddon()
    {
        return $this->belongsTo(ProductAddon::class, 'product_addon_id');
    }

    public function addonOption()
    {
        return $this->belongsTo(AddonOption::class, 'addon_option_id');
    }

}
