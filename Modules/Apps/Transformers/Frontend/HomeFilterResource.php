<?php

namespace Modules\Apps\Transformers\Frontend;

use  Illuminate\Http\Resources\Json\JsonResource;

class HomeFilterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"   => $this->id ,
            'title' => $this->title,
            'url' => route("frontend.products.index",  $this->slug)
        ];
    }
}