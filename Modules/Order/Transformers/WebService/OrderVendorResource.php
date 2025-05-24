<?php

namespace Modules\Order\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Vendor\Traits\VendorTrait;

class OrderVendorResource extends JsonResource
{
    use VendorTrait;

    /* protected $orderId;
    public function __construct($resource)
    {
        $this->orderId = request()->order_id;
        parent::__construct($resource);
    } */

    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'image' => !is_null($this->image) ? url($this->image) : null,
            'title' => $this->title,
            'mobile' => !is_null($this->mobile) ? /* $this->calling_code . */ $this->mobile : null,
            'rate' => $this->getVendorRate($this->id),
        ];

        /*  $request->request->add(['order_id' => $this->orderId]);
        $allOrderProducts = $this->orderProducts->mergeRecursive($this->orderVariations);
        $result['products'] = OrderProductResource::collection($allOrderProducts); */
        return $result;
    }
}
