<?php

namespace Modules\DeviceToken\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class DeviceTokenServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('DeviceToken', 'Database/Migrations'));
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
            module_path('DeviceToken', 'Config/config.php') => config_path('devicetoken.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('DeviceToken', 'Config/config.php'), 'devicetoken'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/devicetoken');

        $sourcePath = module_path('DeviceToken', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/devicetoken';
        }, \Config::get('view.paths')), [$sourcePath]), 'devicetoken');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/devicetoken');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'devicetoken');
        } else {
            $this->loadTranslationsFrom(module_path('DeviceToken', 'Resources/lang'), 'devicetoken');
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
            // app(Factory::class)->load(module_path('DeviceToken', 'Database/factories'));
            $this->loadFactoriesFrom(module_path("DeviceToken", 'Database/factories'));

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
