<?php

namespace Modules\Vendor\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'image' => $this->image ? url($this->image) : url(config('core.config.vendor_category_img_path') . '/default.png'),
            'status' => $this->status,
            'type' => is_null($this->vendor_category_id) ? 'main_category' : 'sub_category',
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
