<?php

namespace Modules\Core\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

abstract class RouteServiceProvider extends ServiceProvider
{
    use LoadsTranslatedCachedRoutes;
    
   

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
      
        
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }
}
