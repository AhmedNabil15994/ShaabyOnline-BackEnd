<?php

namespace Modules\Tags\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class TagsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'color' => $this->color,
            'background' => $this->background,
            'image' => $this->image ? url($this->image) : null,
        ];
    }
}
