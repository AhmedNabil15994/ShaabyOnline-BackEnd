<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Area\Entities\State;

class DriverState extends Model
{
    protected $table = 'driver_state';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

}
