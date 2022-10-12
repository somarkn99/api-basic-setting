<?php

namespace somarkn99\ApiBasicSetting\Providers;

use Illuminate\Support\ServiceProvider;
use somarkn99\ApiBasicSetting\Middleware\AcceptJsonResponse;
use somarkn99\ApiBasicSetting\Middleware\CORS;
use somarkn99\ApiBasicSetting\Middleware\FingerPrintHeader;
use somarkn99\ApiBasicSetting\Middleware\Host;

class ApiSettingProvider extends ServiceProvider
{
    public function boot()
    {
        // Global middleware
        app('router')->aliasMiddleware('AcceptJsonResponse', AcceptJsonResponse::class);
        app('router')->pushMiddlewareToGroup('AcceptJsonResponse', AcceptJsonResponse::class);

        app('router')->aliasMiddleware('CORS', CORS::class);
        app('router')->pushMiddlewareToGroup('CORS', CORS::class);

        app('router')->aliasMiddleware('FingerPrintHeader', FingerPrintHeader::class);
        app('router')->pushMiddlewareToGroup('FingerPrintHeader', FingerPrintHeader::class);


        app('router')->aliasMiddleware('localization', localization::class);
        app('router')->pushMiddlewareToGroup('localization', localization::class);

        app('router')->aliasMiddleware('SecureCheck', SecureCheck::class);
        app('router')->pushMiddlewareToGroup('SecureCheck', SecureCheck::class);

        // Host middleware
        /*
        / Add this only for your dashboard or frontend app
        / Don't use it for mobile application because it recognize it by Ip address for each user mobile
        */
        app('router')->aliasMiddleware('Host', Host::class);
    }

    public function register()
    {
        //
    }
}
