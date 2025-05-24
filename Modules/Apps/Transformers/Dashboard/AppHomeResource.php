<?php

namespace Modules\Apps\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Apps\Entities\AppHome;

class AppHomeResource extends JsonResource
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
            'status' => $this->status,
            'order' => $this->order,
            'title' => $this->title,
            'type' => AppHome::typesForSelect()[$this->type],
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
