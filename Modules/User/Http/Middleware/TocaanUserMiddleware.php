<?php

namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TocaanUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->tocaan_perm) {

            return $next($request);
        } else {
            abort(404);
        }
    }
}
