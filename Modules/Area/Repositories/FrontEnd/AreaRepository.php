<?php

namespace Modules\Area\Repositories\FrontEnd;

use Modules\Area\Entities\City;
use Modules\Area\Entities\State;

class AreaRepository
{
    protected $city;
    protected $state;

    function __construct(City $city, State $state)
    {
        $this->city = $city;
        $this->state = $state;
    }

    public function getChildAreaByParent($request, $order = 'id', $sort = 'desc')
    {
        $query = null;
        if ($request->type == 'city') {
            $query = $this->city->active()->where('country_id', $request->parent_id)->orderBy($order, $sort)->get();
        } elseif ($request->type == 'city_with_states') {
            $query = $this->city->with(['states' => function ($query) {
                $query->has('deliveryCharge');
            }])->whereHas('states', function ($query) {
                $query->has('deliveryCharge');
            })
                ->active()
                ->where('country_id', $request->parent_id)
                ->orderBy($order, $sort)
                ->get();
        } elseif ($request->type == 'state') {
            $query = $this->state->active()->where('city_id', $request->parent_id)->orderBy($order, $sort)->get();
        }
        return $query;
    }
}
