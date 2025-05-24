<?php

namespace Modules\DriverApp\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\WebService\UserResource;
use Modules\Vendor\Traits\VendorTrait;

class OrderResource extends JsonResource
{
    use VendorTrait;

    public function toArray($request)
    {
        // $allOrderProducts = $this->orderProducts->mergeRecursive($this->orderVariations);
        $result = [
            'id' => $this->id,
            'total' => number_format($this->total, 3),
            'shipping' => number_format($this->shipping, 3),
            'subtotal' => number_format($this->subtotal, 3),
            'transaction' => optional($this->transactions)->method,
            'order_status' => [
                'title' => optional($this->orderStatus)->title,
                'image' => optional($this->orderStatus)->image ? url($this->orderStatus->image) : url(config('setting.images.logo')),
                'flag' => optional($this->orderStatus)->flag,
                'is_success' => optional($this->orderStatus)->is_success,
                'sort' => optional($this->orderStatus)->sort,
            ],
            'is_rated' => $this->checkUserRateOrder($this->id),
            'rate' => $this->getOrderRate($this->id),
            'created_at' => date('d-m-Y H:i', strtotime($this->created_at)),
            'notes' => $this->notes,
            // 'products' => OrderProductResource::collection($allOrderProducts),
        ];

        if (is_null($this->unknownOrderAddress)) {
            $result['address'] = new OrderAddressResource($this->orderAddress);
        } else {
            $result['address'] = new UnknownOrderAddressResource($this->unknownOrderAddress);
        }

        if (!is_null($this->driver)) {
            $result['driver'] = new OrderDriverResource($this->driver);
        } else {
            $result['driver'] = null;
        }

        if (!is_null($this->user)) {
            $result['user'] = new UserResource($this->user);
        } else {
            $result['user'] = null;
        }

        if ($this->vendors()->count() > 0) {
            $request->request->add(['order_id' => $this->id]);
            $result['vendors'] = OrderVendorResource::collection($this->vendors);
        }
        return $result;
    }
}
