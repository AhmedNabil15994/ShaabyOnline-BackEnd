<?php

namespace Modules\Vendor\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Vendor\Entities\Vendor;

class VendorServiceProvider extends ServiceProvider
{
    protected $vendor;

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
        $this->loadMigrationsFrom(module_path('Vendor', 'Database/Migrations'));

        App::singleton('vendorObject', function () {

            if (config('setting.other.is_multi_vendors') == 0) {
                $vendorId = config('setting.default_vendor');
                if ($vendorId)
                    return Vendor::find($vendorId);
            }
            return null;
        });

        /** If you use this line of code then it'll be available in any view
         * as $vendorObject but you may also use app('vendorObject') as well
         **/
        View::share('vendorObject', app('vendorObject'));

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
            module_path('Vendor', 'Config/config.php') => config_path('vendor.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Vendor', 'Config/config.php'), 'vendor'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/vendor');

        $sourcePath = module_path('Vendor', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/vendor';
        }, \Config::get('view.paths')), [$sourcePath]), 'vendor');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/vendor');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'vendor');
        } else {
            $this->loadTranslationsFrom(module_path('Vendor', 'Resources/lang'), 'vendor');
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
            // app(Factory::class)->load(module_path('Vendor', 'Database/factories'));
            $this->loadFactoriesFrom(module_path("Vendor", 'Database/factories'));

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
