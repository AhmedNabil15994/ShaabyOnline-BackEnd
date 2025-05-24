<?php

namespace Modules\Vendor\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class OpeningStatusResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'                        => $this->id,
           'status'                    => $this->title,
           'accepting_orders'          => $this->accepted_orders,
       ];
    }
}
