<?php

namespace Modules\Transaction\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
           'method'        => $this->method,
           'auth'          => $this->auth,
           'tran_id'       => $this->tran_id,
           'result'        => $this->result,
           'type'          => $this->transaction->order_status_id ? 'order' : 'subscription',
           'ref'           => $this->ref,
           'track_id'      => $this->track_id,
           'payment_id'    => $this->payment_id,
           'created_at'    => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
