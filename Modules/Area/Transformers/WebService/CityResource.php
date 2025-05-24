<?php

namespace Modules\Area\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'title' => $this->title,
            'status' => $this->status,
        ];

        if ($request->route()->getName() == 'api.areas.countries_with_cities_and_states' || $request->type == 'city_with_states') {
            $result['states'] = StateResource::collection($this->states);
        }

        return $result;
    }
}
