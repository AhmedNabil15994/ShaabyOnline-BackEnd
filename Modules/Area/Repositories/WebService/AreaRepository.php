<?php

namespace Modules\Area\Repositories\WebService;

use function foo\func;
use Modules\Area\Entities\City;
use Modules\Area\Entities\Country;
use Modules\Area\Entities\State;

class AreaRepository
{
    function __construct(City $city, State $state, Country $country)
    {
        $this->state = $state;
        $this->city = $city;
        $this->country = $country;
    }

    public function getAllCountries($order = 'id', $sort = 'desc')
    {
        return $this->country->active()->with('cities')->orderBy($order, $sort)->get();
    }

    public function getAllCitiesByCountryId($countryId, $order = 'id', $sort = 'desc')
    {
        return $this->city->active()->where('country_id', $countryId)->with('states')->orderBy($order, $sort)->get();
    }

    public function getAllStatesByCityCountryId($id, $flag = 'city', $order = 'id', $sort = 'desc')
    {
        if ($flag == 'city') {
            return $this->state->active()->where('city_id', $id)->orderBy($order, $sort)->get();
        } else {
            $country = $this->country->active()->with(['states' => function ($q) {
                $q->where('states.status', 1);
            }])->orderBy('id', 'desc')->find($id);

            return !is_null($country) ? $country->states : null;
        }

    }

    public function getCountriesWithCitiesAndStates($request, $order = 'id', $sort = 'desc')
    {
        $query = $this->country->active()->with(['cities' => function ($q) {
            $q->active();
            $q->with(['states' => function ($q) {
                $q->active();
            }]);
        }]);
        // Get only supported countries from settings
        $query = $query->whereIn('code', config('setting.supported_countries') ?? []);
        return $query->orderBy($order, $sort)->get();
    }

    /*public function getAllCities($order = 'id', $sort = 'desc')
    {
        $cities = $this->city->active()->with('states')->orderBy($order, $sort)->get();
        return $cities;
    }

    public function getAllStates($request)
    {
        if (isset($request['city_id']) && !empty($request['city_id'])) {
            $states = $this->state->active()->where('city_id', $request['city_id'])->orderBy('id', 'desc')->get();
        } else {
            $country = $this->country->active()->with(['states' => function ($q) {
                $q->where('states.status', 1);
            }])->orderBy('id', 'desc')->find($request['country_id']);

            $states = !is_null($country) ? $country->states : null;
        }

        return $states;
    }*/
}
