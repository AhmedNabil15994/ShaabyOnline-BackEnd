<?php

namespace Modules\Area\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class AreaServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('Area', 'Database/Migrations'));
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
            module_path('Area', 'Config/config.php') => config_path('area.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Area', 'Config/config.php'), 'area'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/area');

        $sourcePath = module_path('Area', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/area';
        }, \Config::get('view.paths')), [$sourcePath]), 'area');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/area');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'area');
        } else {
            $this->loadTranslationsFrom(module_path('Area', 'Resources/lang'), 'area');
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
            // app(Factory::class)->load(module_path('Area', 'Database/factories'));
            
            $this->loadFactoriesFrom(module_path("Area", 'Database/factories'));

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
