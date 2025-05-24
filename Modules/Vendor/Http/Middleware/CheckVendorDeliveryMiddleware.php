<?php

namespace Modules\Vendor\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckVendorDeliveryMiddleware
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
        if (config('setting.other.select_shipping_provider') != 'vendor_delivery')
            return abort(404);

        return $next($request);
    }
}
