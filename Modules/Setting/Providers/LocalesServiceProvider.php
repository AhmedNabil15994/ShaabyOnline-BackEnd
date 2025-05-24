<?php

namespace Modules\Setting\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Setting;

class LocalesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (Schema::hasTable('settings')) {
            $this->setLocalesConfigurations();
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    private function setLocalesConfigurations()
    {
        $defaultLocale = Setting::get('default_locale');
        $locales = Setting::get('locales');
        $rtlLocales = Setting::get('rtl_locales');

        if($defaultLocale && $locales && $rtlLocales){
            $this->app->config->set([
                'app.locale' => $defaultLocale,
                'app.fallback_locale' => $defaultLocale,
                'laravellocalization.supportedLocales' => $this->supportedLocales($locales), 'laravellocalization.useAcceptLanguageHeader' => true,
                'laravellocalization.hideDefaultLocaleInURL' => false,
                'default_locale' => $defaultLocale,
                'rtl_locales' => $rtlLocales,
                'translatable.locales' => $locales,
                'translatable.locale' => $defaultLocale,
            ]);
        }
       
    }

    private function supportedLocales($locales)
    {
        return array_intersect_key(config('core.available-locales'), array_flip($locales));
    }
}
