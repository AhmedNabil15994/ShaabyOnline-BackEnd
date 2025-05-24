<?php

namespace Modules\Area\Repositories\FrontEnd;

use Modules\Area\Entities\Country;
use Hash;
use DB;

class CountryRepository
{
    protected $country;

    function __construct(Country $country)
    {
        $this->country = $country;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $query = $this->country->active();
        // Get only supported countries from settings
        $query = $query->whereIn('code', config('setting.supported_countries') ?? []);
        return $query->orderBy($order, $sort)->get();
    }

    public function getCountriesWithCitiesAndStates($request = null, $order = 'id', $sort = 'desc')
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

}
