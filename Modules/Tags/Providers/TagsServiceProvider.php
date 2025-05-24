<?php

namespace Modules\Tags\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Router;

class TagsServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('Tags', 'Database/Migrations'));
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
            module_path('Tags', 'Config/config.php') => config_path('tags.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Tags', 'Config/config.php'), 'tags'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/tags');

        $sourcePath = module_path('Tags', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/tags';
        }, \Config::get('view.paths')), [$sourcePath]), 'tags');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/tags');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'tags');
        } else {
            $this->loadTranslationsFrom(module_path('Tags', 'Resources/lang'), 'tags');
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
            // app(Factory::class)->load(module_path('Tags', 'Database/factories'));
            $this->loadFactoriesFrom(module_path("Tags", 'Database/factories'));

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
