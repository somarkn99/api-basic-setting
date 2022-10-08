<?php

namespace somarkn99\ApiBasicSetting\Middleware;

use Closure;

class Host
{
    public function handle(Request $request, Closure $next)
    {
        $RequestHost = parse_url(\Illuminate\Support\Facades\URL::full())['host'];
        $AcceptedHost = explode(',', env('ACCEPTED_HOST'));

        if (in_array($RequestHost, $AcceptedHost) == true || $RequestHost == 'localhost') {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
