<?php

namespace Modules\Slider\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'image' => !is_null($this->image) ? url($this->image) : null,
            'title' => $this->title,
            'short_description' => $this->short_description,
        ];

        if ($this->morph_model == 'Category') {
            $result['target'] = 'category';
            $result['link'] = $this->sliderable_id ?? null;
        } elseif ($this->morph_model == 'Product') {
            $result['target'] = 'product';
            $result['link'] = $this->sliderable_id ?? null;
        } elseif ($this->morph_model == 'Vendor') {
            $result['target'] = 'vendor';
            $result['link'] = $this->sliderable_id ?? null;
        } else {
            $result['target'] = 'external';
            $result['link'] = $this->link ?? null;
        }
        return $result;
    }
}
