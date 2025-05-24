<?php

namespace Modules\Apps\Providers;

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Core\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    use \Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;
    protected $moduleNamespace = 'Modules\Apps\Http\Controllers';

    protected function mapWebRoutes()
    {
        Route::middleware('web', 'EnableWebsiteRoutes', 'localizationRedirect' , 'localeSessionRedirect', 'localeViewPath' , 'localize')
            ->prefix(LaravelLocalization::setLocale())
            ->namespace($this->moduleNamespace)
            ->group(module_path('Apps', '/Routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api', 'EnableWebsiteRoutes')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Apps', '/Routes/api.php'));
    }
}
