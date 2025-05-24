<?php

namespace Modules\Catalog\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAddonsPermissionMiddleware
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
        if (config('setting.products.toggle_addons') != 1 || !auth()->user()->can('show_product_addons'))
            return abort(404);
        return $next($request);
    }
}
