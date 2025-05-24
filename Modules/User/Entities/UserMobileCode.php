<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserMobileCode extends Model
{
    protected $table = 'user_mobile_codes';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
