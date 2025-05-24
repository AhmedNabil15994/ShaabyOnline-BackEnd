<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Subscription extends Model
{
    use SoftDeletes , ScopesTrait;
    // protected $with               = ['package','vendor','transactions'];
    protected $fillable           = ['original_price', 'status' , 'total' , 'start_at' , 'end_at' , 'package_id' , 'vendor_id'];


    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function vendor()
    {
        return $this->belongsTo(\Modules\Vendor\Entities\Vendor::class);
    }


    public function transactions()
    {
        return $this->morphMany(\Modules\Transaction\Entities\Transaction::class, 'transaction');
    }
}
