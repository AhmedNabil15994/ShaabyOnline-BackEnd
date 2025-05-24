<?php

namespace Modules\Area\Http\Controllers\WebService;

use Illuminate\Http\Request;
use Modules\Area\Repositories\Dashboard\CountryRepository as Country;
use PragmaRX\Countries\Package\Countries;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;

class CountryController extends WebServiceController
{
    protected $country;

    function __construct(Country $country)
    {
        $this->country = $country;
    }

    /**
     ** Get List Of Countries Based On Our Supported Languages **
     **/
    public function index()
    {
        try {

            $countries = new Countries();
            $supportedCountries = $this->country->getAll();
            $requiredCountries = [];

            if ($supportedCountries) {
                foreach ($supportedCountries as $k => $country) {
                    $countryObj = $countries->where('cca2', $country->code)->first();
                    $requiredCountries[$k]['id'] = $country->id;
                    $requiredCountries[$k]['code'] = $country->code;
                    $requiredCountries[$k]['name'] = $country->title;
                    $requiredCountries[$k]['flag'] = isset($countryObj->flag) ? $countryObj->flag->emoji : null;
                    $requiredCountries[$k]['calling_code'] = isset($countryObj->dialling) ? $countryObj->dialling->calling_code[0] : null;
                }
            }
            return $this->response($requiredCountries);

        } catch (\Exception $e) {
            return $this->error(__('apps::api.general.error_happen'), [], 404);
        }
    }

}
