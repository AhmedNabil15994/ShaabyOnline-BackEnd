<?php

namespace Modules\DriverApp\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderVendorResource extends JsonResource
{
    protected $orderId;
    public function __construct($resource)
    {
        $this->orderId = request()->order_id;
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'image' => $this->image ? url($this->image) : null,
            'title' => $this->title,
            'description' => $this->description,
            'address' => $this->address ?? null,
            'mobile' => !is_null($this->mobile) ? /* $this->calling_code . */$this->mobile : null,
        ];
        $request->request->add(['order_id' => $this->orderId]);
        $allOrderProducts = $this->orderProducts->mergeRecursive($this->orderVariations);
        $result['products'] = OrderProductResource::collection($allOrderProducts);
        return $result;
    }
}
