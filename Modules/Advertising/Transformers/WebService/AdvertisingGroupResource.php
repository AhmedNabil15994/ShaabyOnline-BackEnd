<?php

namespace Modules\Advertising\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisingGroupResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'sort' => $this->sort,
            'adverts' => AdvertisingResource::collection($this->adverts),
        ];
    }
}
