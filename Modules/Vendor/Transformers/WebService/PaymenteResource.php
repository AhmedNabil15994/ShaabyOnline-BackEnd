<?php

namespace Modules\Vendor\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymenteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'image'         => url($this->image),
           'code'          => $this->code,
           'title'         => $this->title,
       ];
    }
}
