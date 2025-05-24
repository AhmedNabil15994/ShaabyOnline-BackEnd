<?php

namespace Modules\Area\ViewComposers\Dashboard;

use Modules\Area\Repositories\Dashboard\CityRepository as City;
use Illuminate\View\View;
use Cache;

class CityComposer
{
    public $cities = [];
    public $activeCities = [];

    public function __construct(City $city)
    {
        $this->cities =  $city->getAll();
        $this->activeCities =  $city->getAllActive('id', 'desc', 1); // get all active cities in 'kuwait' country
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['cities' => $this->cities, 'activeCities' => $this->activeCities]);
    }
}
