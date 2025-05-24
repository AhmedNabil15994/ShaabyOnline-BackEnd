<?php

namespace Modules\Vendor\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class AvailabilitiesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'day_code' => $this->day_code,
            'day_name' => __('company::dashboard.companies.availabilities.days.' . $this->day_code),
            'is_full_day' => $this->is_full_day,
            'times' => $this->custom_times,
        ];
    }
}
