<?php

namespace Modules\Catalog\Http\Middleware;

use Closure;
use Cart;

class EmptyAddress
{
     public function handle($request, Closure $next)
    {
        if (!Cart::getCondition('delivery_fees')) {
            return redirect()->route('frontend.order.address.index');
        }

        return $next($request);
    }
}
