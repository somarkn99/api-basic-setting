<?php

namespace somarkn99\ApiBasicSetting\Middleware;

use Closure;

class localization
{
    public function handle($request, Closure $next)
    {
        // Check header request and determine localizaton
        $local = ($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'en';

        // set laravel localization
        app()->setLocale($local);

        // continue request
        return $next($request);
    }
}
