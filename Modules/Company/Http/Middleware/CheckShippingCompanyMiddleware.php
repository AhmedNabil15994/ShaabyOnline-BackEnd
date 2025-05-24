<?php

namespace Modules\Company\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckShippingCompanyMiddleware
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
        if (config('setting.other.select_shipping_provider') != 'shipping_company')
            return abort(404);

        return $next($request);
    }
}
