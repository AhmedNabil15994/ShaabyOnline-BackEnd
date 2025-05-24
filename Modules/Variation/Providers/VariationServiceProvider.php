<?php

namespace Modules\Variation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class VariationServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('Variation', 'Database/Migrations'));
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
            module_path('Variation', 'Config/config.php') => config_path('variation.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Variation', 'Config/config.php'), 'variation'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/variation');

        $sourcePath = module_path('Variation', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/variation';
        }, \Config::get('view.paths')), [$sourcePath]), 'variation');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/variation');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'variation');
        } else {
            $this->loadTranslationsFrom(module_path('Variation', 'Resources/lang'), 'variation');
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
            // app(Factory::class)->load(module_path('Variation', 'Database/factories'));
            $this->loadFactoriesFrom(module_path("Variation", 'Database/factories'));

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
