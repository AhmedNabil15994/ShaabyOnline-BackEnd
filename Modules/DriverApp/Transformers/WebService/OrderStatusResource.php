<?php

namespace Modules\DriverApp\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderStatusResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image ? url($this->image) : url('frontend/images/order-status-logo.png'),
            'flag' => $this->flag,
            'is_success' => $this->is_success,
            'sort' => $this->sort,
        ];
    }
}
