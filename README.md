# API Basic Setting Package

This package allows you to secure and configure the essentials of your business using the API. :sunglasses: 

## Installation

You can install the package via composer:

```php
composer require somarkn99/apibasicsetting
```

## Middleware

1. AcceptJsonResponse Middleware.
---------

It Ensures you will get a response in JSON

```php
class AcceptJsonResponse
{
    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
```

2. CORS.
---------
In order to avoid getting a CORS Error :triumph:

```php
class CORS
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', '*');
        $response->headers->set('Access-Control-Allow-Credentials', true);
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With,Content-Type,X-Token-Auth,Authorization');

        return $response;
    }
}
```

3. FingerPrintHeader
---------
Delete personal information sent with unnecessary requests (in order to increase security) :no_bell: :mute:

```php
class FingerPrintHeader
{
    public function handle($request, Closure $next)
    {
        $request->headers->remove('X-Powered-By');
        $request->headers->remove('Server');

        return $next($request);
    }
}
```

4. Host
---------
As an additional security step, applications are not accepted to a specific domain and are pre-defined in the .env file. :lock: :shield:

- Add this only for your dashboard or frontend app Don't use it for mobile application because it recognize it by Ip address for each user mobile

Note: Local server is accepted by default :v:

```php
class Host
{
    public function handle($request, Closure $next)
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
```

You can add more than one domain and be added as follows:
in your .env file add this:

```
ACCEPTED_HOST=www.somar-kesen.com,api.somar-kesen.com
```

separated between each domain by ","

5. localization
---------
When you work with SPA or Mobile Apps, you do not want to send messages by language other than the user language, for example user language is EN and you send it in Spanish!!

Here you can select the language you want to send to the user, all you need to do is add the language file to the lang folder and add a new item to the array.

From Client side you should send 'X-localization' header, if you don't english will be considered the default language of messages.

```php
class localization
{
    public function handle($request, Closure $next)
    {
        // Check header request and determine localization
        $local = ($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'en';

        // set laravel localization
        app()->setLocale($local);

        // continue request
        return $next($request);
    }
}
```

6. SecureCheck
---------
You are building apps for many customers but don't know if they will use SSL certificates or not, which may cause some features in your app to break down.
For that, this middleware prepares to rejected all requests that don't use https Protocol
(Under Development until know)

```php
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
```

## Helpers

1. _dd
---------
it's allow you to read the dd value from developer section in your browser.

```php
    function _dd(...$args)
    {
        $trace = debug_backtrace();
        $path = '';
        $path .= isset($trace[1]['class']) ? class_basename($trace[1]['class']) : '';
        $path .= isset($trace[1]['function']) ? '@'.$trace[1]['function'].'()' : '';
        $path .= isset($trace[1]['function']) ? ' => line('.$trace[0]['line'].')' : null;

        return response()->json([
            'Path' => $path,
            'dd_Data' => $args,
        ],Response::HTTP_INTERNAL_SERVER_ERROR);
        exit();
    }
```

2. setEnv
---------
You can easily adjust the value of the variables in the .env file

```php
    function setEnv($key, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path,
                str_replace($key.'='.env($key), $key.'='.$value,
                    str_replace($key.'="'.env($key).'"', $key.'="'.$value.'"',
                        file_get_contents($path))
                ));
        }
    }
```

3. checkIfFileExists
---------
This function to check if request has file

```php
    function checkIfFileExists($file, $name)
    {
        if (isset(request()->all()[$name])) {
            if (gettype(request()->all()[$name]) !== 'array') {
                if (! isset($file) || is_null($file) || ! request()->hasFile($name)) {
                    return response()->json('please make sure you store correct file.', Response::HTTP_BAD_REQUEST);
                }
            }
        }
    }
```

4. dateFormat
---------
It's allow you to format your date in function nested of write it every time
for example:

```
$dt = Carbon::create(1975, 12, 25, 14, 15, 16);
echo $dt->toFormattedDateString();                 // Dec 25, 1975
```

```php
function dateFormat($date)
{
    return \Carbon\Carbon::parse($date)->toFormattedDateString();
}
```

Let's Connect
-------

- [Linkedin](https://www.linkedin.com/in/somarkn99/)
- [website](https://www.somar-kesen.com/)
- [facebook](https://www.facebook.com/SomarKesen)
- [instagram](https://www.instagram.com/somar_kn/)

Security
--------

If you discover any security related issues, please email them first to contact@somar-kesen.com,
if we do not fix it within a short period of time please open a new issue describe your problem.
