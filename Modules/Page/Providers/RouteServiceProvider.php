<?php

namespace Modules\Page\Providers;

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
    protected $moduleNamespace = 'Modules\Page\Http\Controllers';

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
          ->group(module_path('Page', '/Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api', 'EnableWebsiteRoutes')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Page', '/Routes/api.php'));
    }
}
