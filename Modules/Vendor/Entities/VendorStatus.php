<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;
use Spatie\Translatable\HasTranslations;

class VendorStatus extends Model
{
    use HasTranslations, ScopesTrait;

    protected $guarded = ["id"];

    public $translatable = ['title'];

}
