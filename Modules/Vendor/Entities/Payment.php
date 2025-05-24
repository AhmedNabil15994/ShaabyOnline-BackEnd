<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

use Spatie\Translatable\HasTranslations;
class Payment extends Model 
{
    use HasTranslations , ScopesTrait;

	 protected $fillable 					= ["code","image","title"];

    public $translatable 	= [ 'title' ];


}
