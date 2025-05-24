<?php

namespace Modules\Area\ViewComposers\Dashboard;

use Modules\Area\Repositories\Dashboard\CountryRepository as Country;
use Illuminate\View\View;
use Cache;

class CountryComposer
{
    public $countries = [];
    public $activeCountries = [];

    public function __construct(Country $country)
    {
        $this->countries =  $country->getAll();
        $this->activeCountries =  $country->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['countries' => $this->countries, 'activeCountries' => $this->activeCountries]);
    }
}
