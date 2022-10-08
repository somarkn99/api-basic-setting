<?php

namespace somarkn99\ApiBasicSetting\Middleware;

use Closure;

class AcceptJsonResponse
{
    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
