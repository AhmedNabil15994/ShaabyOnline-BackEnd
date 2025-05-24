<?php

namespace App\Providers;

use App\Services\Countries;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // telescope
        if ($this->app->isLocal()) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->registerServices();

        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return 'Database\\Factories\\' . \Illuminate\Support\Arr::last(explode('\\', $modelName)) . 'Factory';
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
    }

    public function registerServices()
    {
        // Countries service
        $this->app->singleton('countries', function () {
            return new Countries();
        });
    }
}
