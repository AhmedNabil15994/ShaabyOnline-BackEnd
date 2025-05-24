<?php

namespace Modules\Vendor\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource as Resource;

class SimpleVendorResource extends Resource
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
        ];
    }
}
