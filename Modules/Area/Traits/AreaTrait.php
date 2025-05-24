<?php

namespace Modules\Area\Traits;

use Modules\Area\Repositories\Dashboard\CountryRepository as Country;
use Modules\Vendor\Entities\DeliveryCharge;
use PragmaRX\Countries\Package\Countries;

trait AreaTrait
{
    public function getCountryInfoByCode($country)
    {
        $countries = new Countries();
        $countryObj = $countries->where('cca2', $country->code)->first();

        $desiredCountry['id'] = $country->id;
        $desiredCountry['code'] = $country->code;
        $desiredCountry['name'] = $country->title;
        $desiredCountry['flag'] = isset($countryObj->flag) ? $countryObj->flag->emoji : null;
        $desiredCountry['calling_code'] = isset($countryObj->dialling) ? $countryObj->dialling->calling_code[0] : null;

        return $desiredCountry;
    }
}
