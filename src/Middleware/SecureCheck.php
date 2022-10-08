<?php

namespace somarkn99\ApiBasicSetting\Middleware;

use Closure;

class SecureCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->secure() && App::environment('production')) {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
