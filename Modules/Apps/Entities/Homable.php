<?php

namespace Modules\Apps\Entities;

use Illuminate\Database\Eloquent\Model;

class Homable extends Model
{
    protected $table = 'homables';
    protected $fillable = ["app_home_id", "homable_type", "homable_id"];
}
