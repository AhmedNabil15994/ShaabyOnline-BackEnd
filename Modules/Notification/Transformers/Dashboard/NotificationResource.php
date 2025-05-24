<?php

namespace Modules\Notification\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'user_id' => $this->user->name,
            'title' => $this->title,
            'body' => $this->body,
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];

        if ($this->morph_model == 'Category'){
            $result['model'] = __('notification::dashboard.notifications.form.notification_type.category') .' / '.optional(optional($this->notifiable))->title;
        }elseif ($this->morph_model == 'Product'){
            $result['model'] = __('notification::dashboard.notifications.form.notification_type.product') . ' / '.optional(optional($this->notifiable))->title;
        }else{
            $result['model'] = __('notification::dashboard.notifications.form.notification_type.general');
        }

        return $result;
    }
}
