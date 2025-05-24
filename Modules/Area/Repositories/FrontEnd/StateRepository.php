<?php

namespace Modules\Area\Repositories\FrontEnd;

use Modules\Area\Entities\State;
use Hash;
use DB;

class StateRepository
{
    public function __construct(State $state)
    {
        $this->state = $state;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $states = $this->state->orderBy($order, $sort)->get();
        return $states;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $states = $this->state->has('deliveryCharge')->with('deliveryCharge')->active()->orderBy($order, $sort)->get();
        return $states;
    }

    public function getAllActiveStates($order = 'id', $sort = 'desc')
    {
        $states = $this->state->with('deliveryCharge')->active()->orderBy($order, $sort)->get();
        return $states;
    }

    public function getAllActiveHomeStates($order = 'id', $sort = 'desc')
    {
        $states = $this->state->active()->orderBy($order, $sort)->get();
        return $states;
    }

    public function getAllStatesByCityId($cityId)
    {
        return $this->state->where('city_id', $cityId)->get();
    }

    public function findBySlug($slug)
    {
        $state = $this->state->anyTranslation('slug', $slug)->first();

        return $state;
    }

    public function checkRouteLocale($model, $slug)
    {
        // if ($model->translate()->where('slug', $slug)->first()->locale != locale()) {
        //     return false;
        // }

        if ($array = $model->getTranslations("slug")) {
            $locale = array_search($slug, $array);

            return $locale == locale();
        }

        return true;
    }
}
