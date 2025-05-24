<?php

namespace Modules\Advertising\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisingResource extends JsonResource
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
           'image'         => url($this->image),
           'link'          => $this->link,
           'start_at'      => $this->start_at,
           'end_at'        => $this->end_at,
           'status'        => $this->status,
           'deleted_at'    => $this->deleted_at,
           'created_at'    => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
