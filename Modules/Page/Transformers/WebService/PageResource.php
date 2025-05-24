<?php

namespace Modules\Page\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'title'         => $this->title,
           'description'   => htmlView($this->description),
       ];
    }
}
