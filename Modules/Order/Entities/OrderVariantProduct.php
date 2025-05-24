<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderVariantProduct extends Model
{
    protected $guarded = ['id'];

    public function variant()
    {
        return $this->belongsTo(\Modules\Variation\Entities\ProductVariant::class, 'product_variant_id');
    }

    public function orderVariantValues()
    {
        return $this->hasMany(OrderVariantProductValue::class);
    }

    public function refund()
    {
        return $this->morphOne(OrderRefundItem::class, 'item');
    }

    public function refundOperation($qty, $increment_stock)
    {
        $refund_money =  $this->total;
        $currentQty   =  $qty;
        $refundQty   =  $this->qty - $qty;
        $newTotal        = $currentQty * $this->sale_price;
        $newOriginalTotal  = $currentQty * $this->price;

        $refund_money =  $refund_money - $newTotal;

        $data = [
            "qty"       => $currentQty,
            "is_refund" => $currentQty == 0,
            "total"      => $newTotal,
            'original_total' => $newOriginalTotal,
            "total_profit"  => $newTotal - $newOriginalTotal
        ];

        $this->update($data);
        $refund = $this->refund;

        if ($refund) {
            $refund->qty += $refundQty;
            $refund->total  += $refund_money;
            $refund->save();
        } else {
            $this->refund()->create([
                "qty"       => $refundQty,
                "total"     => $refund_money
            ]);
        }

        if ($increment_stock && $this->variant) {

            $this->variant()->increment('qty', $refundQty);
        }

        return $refund_money;
    }
}
