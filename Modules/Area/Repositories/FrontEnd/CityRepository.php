<?php

namespace Modules\Area\Repositories\FrontEnd;

use Modules\Area\Entities\City;
use Hash;
use DB;

class CityRepository
{
    protected $city;

    function __construct(City $city)
    {
        $this->city = $city;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $citys = $this->city->with([])->with([
            'states' => function ($query) {
                $query->active();
            }
        ])->active()->orderBy($order, $sort)->get();

        return $citys;
    }

    public function getAllCitiesByCountryId($countryId, $order = 'id', $sort = 'desc')
    {
        return $this->city->active()->where('country_id', $countryId)->with('states')->orderBy($order, $sort)->get();
    }

    public function getCitiesWithStatesDelivery($order = 'id', $sort = 'desc')
    {
        return $this->city->whereHas('states', function ($query) {
            $query->has('deliveryCharge');
        })->with(['states' => function ($query) {
            $query->has('deliveryCharge');
        }])->active()->where('country_id', 1)->orderBy($order, $sort)->get();
    }
}
