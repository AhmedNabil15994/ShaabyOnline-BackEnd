<?php

namespace Modules\Subscription\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
           'status'        => $this->status,
           'start_at'      => $this->start_at,
           'end_at'        => $this->end_at,
           'total'         => $this->total,
           'original_price'=> $this->original_price,
           'vendor_id'     => $this->vendor->title,
           'package_id'    => $this->package->title,
           'deleted_at'    => $this->deleted_at,
           'created_at'    => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
