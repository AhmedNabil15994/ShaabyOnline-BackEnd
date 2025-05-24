<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class VendorDriver extends Model
{
    protected $table = 'vendor_drivers';
    protected $fillable = ['user_id', 'vendor_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

}
