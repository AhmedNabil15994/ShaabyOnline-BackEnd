<?php

namespace Modules\Vendor\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSingleVendorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (config('setting.other.is_multi_vendors') == 0 && !empty(config('setting.default_vendor')))
            return abort(404);
        return $next($request);
    }
}
