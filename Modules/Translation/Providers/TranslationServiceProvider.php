<?php

namespace Modules\Translation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class TranslationServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('Translation', 'Database/Migrations'));
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
            module_path('Translation', 'Config/config.php') => config_path('translation.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Translation', 'Config/config.php'), 'translation'
        );

        // laravel-translation-manager.php
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/translation');

        $sourcePath = module_path('Translation', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/translation';
        }, \Config::get('view.paths')), [$sourcePath]), 'translation');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/translation');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'translation');
        } else {
            $this->loadTranslationsFrom(module_path('Translation', 'Resources/lang'), 'translation');
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
            // app(Factory::class)->load(module_path('Translation', 'Database/factories'));
            $this->loadFactoriesFrom(module_path("Translation", 'Database/factories'));

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
