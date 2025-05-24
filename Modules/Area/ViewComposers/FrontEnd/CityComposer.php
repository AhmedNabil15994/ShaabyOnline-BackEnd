<?php

namespace Modules\Area\ViewComposers\FrontEnd;

use Modules\Area\Repositories\FrontEnd\CityRepository as City;
use Illuminate\View\View;
use Cache;

class CityComposer
{
    public $cities = [];
    public $citiesWithStatesDelivery;

    public function __construct(City $city)
    {
        $this->cities =  $city->getAllActive();
        $this->citiesWithStatesDelivery = $city->getCitiesWithStatesDelivery();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['cities' => $this->cities, 'citiesWithStatesDelivery' => $this->citiesWithStatesDelivery]);
    }
}
