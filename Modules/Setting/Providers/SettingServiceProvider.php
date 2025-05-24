<?php

namespace Modules\Setting\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Setting;

class SettingServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(module_path('Setting', 'Database/Migrations'));

        if (Schema::hasTable('settings')) {
            $this->setSettingConfigurations();
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(LocalesServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        // $this->app->bind(SettingInterface::class,SettingRepository::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Setting', 'Config/config.php') => config_path('setting.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Setting', 'Config/config.php'),
            'setting'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/setting');

        $sourcePath = module_path('Setting', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/setting';
        }, \Config::get('view.paths')), [$sourcePath]), 'setting');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/setting');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'setting');
        } else {
            $this->loadTranslationsFrom(module_path('Setting', 'Resources/lang'), 'setting');
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
            // app(Factory::class)->load(module_path('Setting', 'Database/factories'));
            $this->loadFactoriesFrom(module_path("Setting", 'Database/factories'));

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


    private function setSettingConfigurations()
    {
        $settings = [
            'setting' => [
                'app_name' => Setting::get('app_name'),
                'app_description' => Setting::get('app_description'),
                'address' => Setting::get('address'),
                'default_vendor_id' => Setting::get('default_vendor'),
                'other' => Setting::get('other'),
                'products' => Setting::get('products'),
                'social' => Setting::get('social'),

                /* 'logo' => Setting::get('logo') ? url(Setting::get('logo')) : null,
                'white_logo' => Setting::get('white_logo') ? url(Setting::get('white_logo')) : null,
                'favicon' => Setting::get('favicon') ? url(Setting::get('favicon')) : null, */

                'images' => Setting::get('images'),

                'contact_us' => Setting::get('contact_us'),
                'default_vendor' => Setting::get('default_vendor'),
                'supported_countries' => Setting::get('countries'),
                'order_status' => Setting::get('order_status'),
                'custom_codes' => Setting::get('custom_codes'),
                // 'payment_gateway' => Setting::get('payment_gateway'),
                'about_app' => Setting::get('about_app'),
                'app_gallery' => Setting::get('app_gallery'),

                'supported_payments' => Setting::get('supported_payments'),
                'theme_sections' => Setting::get('theme_sections'),
            ],

        ];
        $this->app->config->set($settings);
    }
}
