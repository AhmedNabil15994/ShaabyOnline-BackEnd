<?php

namespace App\Services;

use Illuminate\Support\Str;
use PragmaRX\Countries\Package\Countries as BaseCountries;

class Countries extends BaseCountries
{
    /**
     * @return array
     */
    public function listByName(): array
    {
        return $this->all()->pluck('name.common')->toArray();
    }

    /**
     * @return array
     */
    public function listWithCodes() : array
    {
        return $this->all()
            ->map(function ($country) {
                return [
                    'code' => $country->cca2,
                    'name' => $country->name->common,
                ];
            })->values()
            ->toArray();
    }

    /**
     * Accepts ISO_a2 codes: EG, KW, etc...
     *
     * @param string $code
     *
     * @return string|null
     */
    public function dialCode($code)
    {
        return ($country = $this->where('iso_a2', Str::upper($code))->first())
            ? $country->toArray()['dialling']['calling_code'][0]
            : null;
    }

    /**
     * Accepts ISO_a2 codes: EG, KW, etc...
     * returns +965, +20, etc..
     *
     * @param string $code
     *
     * @return string|null
     */
    public function formattedDialCode($code)
    {
        return ($formatted = $this->dialCode($code))
            ? "+${formatted}"
            : null;
    }
}
