<?php

namespace Modules\Authorization\Entities;

use Zizaco\Entrust\EntrustRole;

use Spatie\Translatable\HasTranslations;

class Role extends EntrustRole
{
    use HasTranslations;

    protected $with = [];
    protected $fillable = ["name", "display_name", "description"];
    public $translatable = ['display_name', 'description'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
