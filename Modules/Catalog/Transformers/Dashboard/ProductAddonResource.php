<?php

namespace Modules\Catalog\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource as Resource;

class ProductAddonResource extends Resource
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
            'title' => $this->addonCategory->title,
            'addon_category_id' => $this->addon_category_id,
            'type' => $this->type,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
