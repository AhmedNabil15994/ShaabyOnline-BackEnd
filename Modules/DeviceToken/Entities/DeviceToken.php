<?php

namespace Modules\DeviceToken\Entities;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $fillable = ['platform','user_id','device_token','lang'];
}
