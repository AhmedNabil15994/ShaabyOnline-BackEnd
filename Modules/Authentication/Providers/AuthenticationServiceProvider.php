<?php

namespace Modules\Authentication\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class AuthenticationServiceProvider extends ServiceProvider
{

    protected $middleware = [
        'Authentication' => [
            'driver.auth'     => 'DriverAuthenticate',
            'vendor.auth'     => 'VendorAuthenticate',
            'dashboard.auth'  => 'DashboardAuthenticate',
            'auth'            => 'Authenticate',
        ],
    ];

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMiddleware($this->app['router']);
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Authentication', 'Database/Migrations'));
    }


    /**
     * Register the filters.
     *
     * @param  Router $router
     * @return void
     */
    public function registerMiddleware(Router $router)
    {
        foreach ($this->middleware as $module => $middlewares) {
            foreach ($middlewares as $name => $middleware) {
                $class = "Modules\\{$module}\\Http\\Middleware\\{$middleware}";

                $router->aliasMiddleware($name, $class);
            }
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Authentication', 'Config/config.php') => config_path('authentication.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Authentication', 'Config/config.php'), 'authentication'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/authentication');

        $sourcePath = module_path('Authentication', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/authentication';
        }, \Config::get('view.paths')), [$sourcePath]), 'authentication');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/authentication');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'authentication');
        } else {
            $this->loadTranslationsFrom(module_path('Authentication', 'Resources/lang'), 'authentication');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            // app(Factory::class)->load(module_path('Authentication', 'Database/factories'));
            $this->loadFactoriesFrom(module_path("Authentication", 'Database/factories'));

        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
