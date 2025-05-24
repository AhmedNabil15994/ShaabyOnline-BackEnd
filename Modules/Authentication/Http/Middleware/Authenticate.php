<?php

namespace Modules\Authentication\Http\Middleware;

use Closure;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (!$request->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }
        return $next($request);
    }
}