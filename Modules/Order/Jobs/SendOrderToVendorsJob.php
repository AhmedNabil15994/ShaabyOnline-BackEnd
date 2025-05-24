<?php

namespace Modules\Order\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Order\Mail\FrontEnd\SendOrderToVendorsMail;
use Illuminate\Support\Facades\Mail;
use Modules\Order\Entities\Order;

class SendOrderToVendorsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orderId = $this->order->id;
        $orderVendors = $this->order->vendors;
        foreach ($orderVendors as $k => $vendor) {
            $orderObject = null;
            $vendorEmails = [];
            $vendorExtraData = [
                'subtotal' => $vendor->pivot->subtotal,
                'qty' => $vendor->pivot->qty,
            ];

            $orderObject = $this->getVendorProductsByOrderId($orderId, $vendor->id);

            if (!empty($vendor->emails)) {
                $vendorEmails = $vendor->emails;
            }
            if (!is_null($vendor->vendor_email)) {
                $vendorEmails[] = $vendor->vendor_email;
            }

            if (!empty($vendorEmails)) {
                $emailTemplate = new SendOrderToVendorsMail($orderObject, $vendorExtraData);
                Mail::to($vendorEmails)->send($emailTemplate);
            }
        }

        return true;
    }

    private function getVendorProductsByOrderId($orderId, $vendorId)
    {
        return Order::with([
            'orderProducts' => function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            },
            'orderVariations' => function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            },
        ])
            ->whereHas('vendors', function ($q) use ($vendorId) {
                $q->where('order_vendors.vendor_id', $vendorId);
            })
            ->find($orderId);
    }
}
