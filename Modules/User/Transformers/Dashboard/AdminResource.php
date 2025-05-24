<?php

namespace Modules\User\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'image' => url($this->image),
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];

        if ($this->roles) {
            $numItems = count($this->roles->toArray());
            $i = 0;
            $roleName = '';
            foreach ($this->roles as $k => $role) {
                $roleName .= $role->display_name;
                if (++$i !== $numItems) { // if it is not the last index
                    $roleName .= ' - ';
                }
            }
            $data['roles'] = $roleName;
        } else {
            $data['roles'] = '';
        }
        return $data;
    }
}
