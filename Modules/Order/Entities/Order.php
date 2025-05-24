<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Company\Entities\Company;
use Modules\Core\Traits\ScopesTrait;
use Modules\Vendor\Entities\Vendor;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;

class Order extends Model
{
    use SoftDeletes, ScopesTrait;
    // use LogsActivity;

    // protected $with 	= ['orderStatus','user','vendor'];
    protected $guarded = ['id'];
    protected $appended = [
        'order_flag'
    ];
    protected $casts = [
        'shipping_details' => 'array',
        'delivery_time' => 'array',
        'payment_commissions' => 'array',
    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /* public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn (string $eventName) => "This model has been : {$eventName}");
    } */

    public function getOrderFlagAttribute()
    {
        $orderStatusFlag = $this->orderStatus->flag ?? '';
        if (in_array($orderStatusFlag, ['new_order', 'received', 'processing', 'is_ready'])) {
            return 'current_orders';
        } elseif (in_array($orderStatusFlag, ['on_the_way', 'delivered'])) {
            return 'completed_orders';
        } elseif (in_array($orderStatusFlag, ['failed'])) {
            return 'not_completed_orders';
        } elseif (in_array($orderStatusFlag, ['refund'])) {
            return 'refunded_orders';
        } else {
            return 'all_orders';
        }
    }

    public function scopeSuccessOrders($query)
    {
        return $query->whereHas('orderStatus', function ($q) {
            $q->where('is_success', 1);
        });
    }

    public function scopeFailedOrders($query)
    {
        return $query->whereHas('orderStatus', function ($q) {
            $q->where('is_success', 0);
        });
    }

    public function transactions()
    {
        return $this->morphOne(\Modules\Transaction\Entities\Transaction::class, 'transaction');
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

    public function user()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class);
    }

    /*public function vendor()
    {
        return $this->belongsTo(\Modules\Vendor\Entities\Vendor::class);
    }*/

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id')->where("is_refund", 0);
    }

    public function orderVariations()
    {
        return $this->hasMany(OrderVariantProduct::class, 'order_id')->where("is_refund", 0);
    }

    public function orderAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id');
    }

    public function unknownOrderAddress()
    {
        return $this->hasOne(UnknownOrderAddress::class, 'order_id');
    }

    public function driver()
    {
        return $this->hasOne(OrderDriver::class, 'order_id');
    }

    public function rate()
    {
        return $this->hasOne(\Modules\Vendor\Entities\Rate::class, 'order_id');
    }

    public function orderCards()
    {
        return $this->hasMany(OrderCard::class, 'order_id');
    }

    public function orderGifts()
    {
        return $this->hasMany(OrderGift::class, 'order_id');
    }

    public function orderAddons()
    {
        return $this->hasMany(OrderAddons::class, 'order_id');
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'order_vendors')->withPivot('total_comission', 'total_profit_comission', 'subtotal', 'qty');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'order_companies')->withPivot('vendor_id', 'availabilities', 'delivery');
    }

    public function orderStatusesHistory()
    {
        return $this->belongsToMany(OrderStatus::class, 'order_statuses_history')->withPivot(['id', 'user_id'])->withTimestamps();
    }

    public function orderCoupons()
    {
        return $this->hasOne(OrderCoupon::class, 'order_id');
    }

    public function subRefund($refund)
    {
        $this->update([
            "original_subtotal"  => $this->original_subtotal > $refund ? $this->original_subtotal - $refund : 0,
            "subtotal"           => $this->subtotal > $refund ? $this->subtotal - $refund : 0,
            "total"              => $this->total > $refund ? $this->total - $refund : 0,

        ]);
    }
}
