<?php

namespace Modules\Area\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Modules\Area\Transformers\WebService\CityResource;
use Modules\Area\Transformers\WebService\CountryResource;
use Modules\Area\Transformers\WebService\StateResource;
use Modules\Area\Repositories\WebService\AreaRepository as Area;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;

class AreaController extends WebServiceController
{
    protected $area;

    function __construct(Area $area)
    {
        $this->area = $area;
    }

    public function countries(Request $request)
    {
        $countries = $this->area->getAllCountries();
        $result = $countries ? CountryResource::collection($countries) : [];
        return $this->response($result);
    }

    public function getCountriesWithCitiesAndStates(Request $request)
    {
        $countries = $this->area->getCountriesWithCitiesAndStates($request);
        $result = $countries ? CountryResource::collection($countries) : [];
        return $this->response($result);
    }

    public function cities(Request $request, $id)
    {
        $cities = $this->area->getAllCitiesByCountryId($id);
        $result = $cities ? CityResource::collection($cities) : [];
        return $this->response($result);
    }

    public function states(Request $request, $id)
    {
        $states = $this->area->getAllStatesByCityCountryId($id, $request->flag);
        $result = $states ? StateResource::collection($states) : [];
        return $this->response($result);
    }
}
