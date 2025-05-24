<?php

namespace Modules\Catalog\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource as Resource;

class SimpleAddonOptionsResource extends Resource
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
            'image' => $this->image ? url($this->image) : null,
            'price' => $this->price,
            'qty' => $this->qty,
            'default' => checkIfAddonOptionIsDefault($request->product_id ?? null, $request->addon_category_id ?? null, $this->id),
        ];
    }
}
