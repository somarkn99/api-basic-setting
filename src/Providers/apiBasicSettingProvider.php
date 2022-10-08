<?php

namespace somarkn99\ApiBasicSetting\Providers;

use Illuminate\Support\ServiceProvider;
use somarkn99\ApiBasicSetting\Middleware\{AcceptJsonResponse,CORS,FingerPrintHeader,Host};
use Illuminate\Contracts\Http\Kernel;

class ApiSettingProvider extends ServiceProvider
{
    public function boot(Kernel $kernel)
    {
        // Global middleware
        $kernel->pushMiddleware(AcceptJsonResponse::class);
        $kernel->pushMiddleware(CORS::class);
        $kernel->pushMiddleware(FingerPrintHeader::class);
        $kernel->pushMiddleware(Host::class);
        $kernel->pushMiddleware(localization::class);
        $kernel->pushMiddleware(SecureCheck::class);
    }

    public function register()
    {
        //
    }
}
