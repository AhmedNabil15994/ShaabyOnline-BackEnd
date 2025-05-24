<?php

namespace Modules\Vendor\Repositories\Vendor;

use Modules\Vendor\Entities\Vendor;
use Modules\Order\Entities\Order;
use Modules\Vendor\Entities\Rate;
use Auth;
use DB;

class RateRepository
{
    function __construct(Order $order, Vendor $vendor, Rate $rate)
    {
        $this->vendor = $vendor;
        $this->order = $order;
        $this->rate = $rate;
    }

    public function checkUserRate($id)
    {
        $rate = $this->rate
            ->where('user_id', auth()->id())
            ->where('order_id', $id)
            ->first();
        return $rate;
    }

    public function findOrderByIdWithUserId($id)
    {
        $order = $this->order->where('user_id', auth()->id())->find($id);
        return $order;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $rateCreated = $this->rate->create([
                'vendor_id' => $request->vendor_id,
                'order_id' => $request->order_id,
                'user_id' => auth()->id(),
                'rating' => $request->rating,
                'comment' => $request['comment'] ?? $request['comment'],
            ]);

            DB::commit();
            return $rateCreated;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

}
