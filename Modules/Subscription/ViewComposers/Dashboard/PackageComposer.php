<?php

namespace Modules\Subscription\ViewComposers\Dashboard;

use Modules\Subscription\Repositories\Dashboard\PackageRepository as Package;
use Illuminate\View\View;
use Cache;

class PackageComposer
{
    public $packages = [];

    public function __construct(Package $package)
    {
        $this->packages =  $package->getAll();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('packages' , $this->packages);
    }
}
