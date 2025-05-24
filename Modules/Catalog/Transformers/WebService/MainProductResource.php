<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class MainProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'                   => $this->id,
           'image'                => url($this->image),
           'title'                => $this->title,
           'description'          => htmlView($this->description),
           'short_description'    => $this->short_description,
       ];
    }
}
