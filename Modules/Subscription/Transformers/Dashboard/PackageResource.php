<?php

namespace Modules\Subscription\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
           'id'            => $this->id,
           'title'         => $this->title,
           'description'   => $this->description,
           'status'        => $this->status,
           'months'        => $this->months,
           'price'         => $this->price,
           'special_price' => $this->special_price,
           'deleted_at'    => $this->deleted_at,
           'created_at'    => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
