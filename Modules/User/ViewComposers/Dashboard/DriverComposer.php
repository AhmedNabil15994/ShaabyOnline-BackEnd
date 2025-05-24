<?php

namespace Modules\User\ViewComposers\Dashboard;

use Modules\User\Repositories\Dashboard\DriverRepository as Driver;
use Illuminate\View\View;
use Cache;

class DriverComposer
{
    public $drivers = [];

    public function __construct(Driver $driver)
    {
        $this->drivers =  $driver->getAllDrivers();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('drivers' , $this->drivers);
    }
}
