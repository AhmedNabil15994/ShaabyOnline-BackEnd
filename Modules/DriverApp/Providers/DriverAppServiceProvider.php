<?php

namespace Modules\DriverApp\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class DriverAppServiceProvider extends ServiceProvider
{
    protected $middleware = [
        'DriverApp' => [
            'IsDriverAppUser' => 'IsDriverAppUserMiddleware',
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
        $this->loadMigrationsFrom(module_path('DriverApp', 'Database/Migrations'));
    }

    /**
     * Register the filters.
     *
     * @param Router $router
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
            module_path('DriverApp', 'Config/config.php') => config_path('driver_app.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('DriverApp', 'Config/config.php'), 'driver_app'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/driver_app');

        $sourcePath = module_path('DriverApp', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/driver_app';
        }, \Config::get('view.paths')), [$sourcePath]), 'driver_app');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/driver_app');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'driver_app');
        } else {
            $this->loadTranslationsFrom(module_path('DriverApp', 'Resources/lang'), 'driver_app');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            $this->loadFactoriesFrom(module_path("DriverApp", 'Database/factories'));
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
