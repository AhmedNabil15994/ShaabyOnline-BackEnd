<?php

namespace App\Http\Middleware;

use Closure;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CheckVendorDashboardRoutesMiddleware
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
        $locale = LaravelLocalization::setLocale();
        if ($request->is($locale . '/vendor-dashboard') || $request->is($locale . '/vendor-dashboard/*')) {
            if (auth()->check() && $request->user()->can('dashboard_access')) {
                auth()->logout();
                return redirect()->route('vendor.login');
            }
        } elseif ($request->is($locale . '/dashboard') || $request->is($locale . '/dashboard/*')) {
            if (auth()->check() && $request->user()->can('seller_access')) {
                auth()->logout();
                return redirect()->route('dashboard.login');
            }
        }

        return $next($request);
    }
}
