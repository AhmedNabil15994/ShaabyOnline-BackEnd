<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class SubscriptionHistory extends Model
{
    use SoftDeletes , ScopesTrait;

    protected $table              = 'subscription_history';
    protected $with               = ['package','vendor'];
    protected $fillable           = ['total', 'status' , 'start_at' , 'end_at' , 'package_id' , 'vendor_id'];


    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function vendor()
    {
        return $this->belongsTo(\Modules\Vendor\Entities\Vendor::class);
    }
}
