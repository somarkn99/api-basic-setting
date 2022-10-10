<?php

namespace somarkn99\ApiBasicSetting\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class SecureCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->secure() && App::environment('production')) {
            return response()->json("Please use https protocol so you can send requests.", Response::HTTP_BAD_REQUEST);
        }

        return $next($request);
    }
}
