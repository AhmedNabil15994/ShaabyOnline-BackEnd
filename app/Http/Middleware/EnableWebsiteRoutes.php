<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class EnableWebsiteRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        ### Start - Hide Website Frontend Pages ###
        if (config('setting.other.enable_website') != '1') {
            $locale = LaravelLocalization::setLocale();
            if (
                !is_null($request->segment(1))
                && !$request->is('/storage/*')
                && !$request->is('filemanager/*')
                && !$request->is('filemanager')
                && !$request->is('laravel-filemanager/*')
                && !$request->is($locale . '/dashboard')
                && !$request->is($locale . '/dashboard/*')
                && !$request->is($locale . '/vendor-dashboard')
                && !$request->is($locale . '/vendor-dashboard/*')
                && !$request->is($locale . '/driver-dashboard')
                && !$request->is($locale . '/driver-dashboard/*')
                && !$request->is('api/*')
                && !$request->is('reset/*')
                && !$request->is($locale . '/reset')
                && !$request->is($locale . '/reset/*')
                && $request->route()->getName() != 'frontend.home'
            ) {
                return abort(404);
            }
        }
        ### End - Hide Website Frontend Pages ###

        return $next($request);
    }
}
