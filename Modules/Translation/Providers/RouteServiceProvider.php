<?php

namespace Modules\Translation\Providers;

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Core\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Translation\Http\Controllers';

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
      Route::middleware('web', 'EnableWebsiteRoutes', 'localizationRedirect' , 'localeSessionRedirect', 'localeViewPath' , 'localize')
          ->prefix(LaravelLocalization::setLocale())
          ->namespace($this->moduleNamespace)
          ->group(module_path('Translation', '/Routes/web.php'));
    }


    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api', 'EnableWebsiteRoutes')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Translation', '/Routes/api.php'));
    }
}
