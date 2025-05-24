<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('ltm-admin-translations', function ($user) {
            /* @var $user \App\User */
            // modify the code below to return true for users that can administer translations
            // return $user && $user->is_admin;
            return $user;
        });

        Gate::define('ltm-bypass-lottery', function ($user) {
            /* @var $user \App\User */
            // modify the code below to return true for users that can administer translations
            // or edit translation so that missing keys will be logged for all sessions of
            // these users instead of one out of N sessions as given by random lottery result
            // return $user && ($user->is_admin || $user->is_editor);
            return $user;
        });

        Gate::define('ltm-list-editors', function ($user, $connection_name, &$user_list) {
            /* @var $connection_name string */
            /* @var $user \App\User */
            /* @var $query  \Illuminate\Database\Query\Builder */
            $query = $user->on($connection_name)->getQuery();

            // modify the query to return only users that can edit translations and can be
            // managed by $user if you have a an editor scope defined on your user model
            // you can use it to filter only translation editors
            $user_list = $query->orderby('id')->get(['id', 'email']);

            // if the returned list is empty then no per locale admin will be shown for
            // the current user.
            return $user_list;
        });

        Passport::routes();
        Passport::tokensExpireIn(now()->addYears(3));
        Passport::refreshTokensExpireIn(now()->addYears(3));
        Passport::personalAccessTokensExpireIn(now()->addYears(3));

    }
}
