<?php

namespace Modules\Catalog\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource as Resource;

class AddonOptionResource extends Resource
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
            'addon_category' => optional($this->addonCategory)->title ?? '---',
            'image' => $this->image ? url($this->image) : null,
            'price' => $this->price,
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
