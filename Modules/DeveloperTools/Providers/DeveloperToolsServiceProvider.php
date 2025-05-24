<?php

namespace Modules\DeveloperTools\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class DeveloperToolsServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('DeveloperTools', 'Database/Migrations'));
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
            module_path('DeveloperTools', 'Config/config.php') => config_path('developertools.php'),
            module_path('DeveloperTools', 'Config/fronttheme.php') => config_path('developertools.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('DeveloperTools', 'Config/config.php'), 'developertools'
        );
        $this->mergeConfigFrom(
            module_path('DeveloperTools', 'Config/fronttheme.php'), 'fronttheme'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/developertools');

        $sourcePath = module_path('DeveloperTools', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/developertools';
        }, \Config::get('view.paths')), [$sourcePath]), 'developertools');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/developertools');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'developertools');
        } else {
            $this->loadTranslationsFrom(module_path('DeveloperTools', 'Resources/lang'), 'developertools');
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
            $this->loadFactoriesFrom(module_path('DeveloperTools', 'Database/factories'));
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
