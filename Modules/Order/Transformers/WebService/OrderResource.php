<?php

namespace Modules\Order\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Vendor\Traits\VendorTrait;
use Modules\Vendor\Transformers\WebService\VendorResource;

class OrderResource extends JsonResource
{
    use VendorTrait;

    public function toArray($request)
    {
        $allOrderProducts = $this->orderProducts->mergeRecursive($this->orderVariations);
        $result = [
            'id' => $this->id,
            'total' => number_format($this->total, 3),
            'shipping' => number_format($this->shipping, 3),
            'subtotal' => number_format($this->subtotal, 3),
            'transaction' => optional($this->transactions)->method,
            'order_status' => [
                'flag' => optional($this->orderStatus)->flag,
                'title' => optional($this->orderStatus)->title,
            ],
            'is_rated' => $this->checkUserRateOrder($this->id),
            'rate' => $this->getOrderRate($this->id),
            'created_at' => date('d-m-Y H:i', strtotime($this->created_at)),
            'notes' => $this->notes,
            'products' => OrderProductResource::collection($allOrderProducts),
        ];

        $result['address'] = new OrderAddressResource($this->orderAddress);

        /*if (is_null($this->unknownOrderAddress)) {
            $result['address'] = new OrderAddressResource($this->orderAddress);
        } else {
            $result['address'] = new UnknownOrderAddressResource($this->unknownOrderAddress);
        }*/

        if ($this->vendors()->count() > 0) {
            // $request->request->add(['order_id' => $this->id]);
            $result['vendors'] = OrderVendorResource::collection($this->vendors);
        }

        return $result;
    }
}
