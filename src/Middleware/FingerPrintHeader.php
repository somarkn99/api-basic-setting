<?php

namespace somarkn99\ApiBasicSetting\Middleware;

use Closure;

class FingerPrintHeader
{
    public function handle($request, Closure $next)
    {
        $request->headers->remove('X-Powered-By');
        $request->headers->remove('Server');

        return $next($request);
    }
}
