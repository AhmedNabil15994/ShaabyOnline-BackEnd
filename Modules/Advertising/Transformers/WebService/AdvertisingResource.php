<?php

namespace Modules\Advertising\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisingResource extends JsonResource
{
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'image' => $this->image ? url($this->image) : null,
            'sort' => $this->sort,
        ];

        if (is_null($this->advertable_id) && !is_null($this->link)) {
            $result['target'] = 'external';
            $result['link'] = $this->link;
        } elseif (!is_null($this->advertable_id) && $this->morph_model == 'Product') {
            $result['target'] = 'product';
            $result['link'] = $this->advertable_id;
        } elseif (!is_null($this->advertable_id) && $this->morph_model == 'Category') {
            $result['target'] = 'category';
            $result['link'] = $this->advertable_id;
        } elseif (!is_null($this->advertable_id) && $this->morph_model == 'Vendor') {
            $result['target'] = 'vendor';
            $result['link'] = $this->advertable_id;
        }

        return $result;
    }
}
