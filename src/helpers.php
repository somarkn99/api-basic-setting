<?php

use Symfony\Component\HttpFoundation\Response;

if (! function_exists('_dd')) {
    function _dd(...$args)
    {
        $trace = debug_backtrace();
        $path = '';
        $path .= isset($trace[1]['class']) ? class_basename($trace[1]['class']) : '';
        $path .= isset($trace[1]['function']) ? '@'.$trace[1]['function'].'()' : '';
        $path .= isset($trace[1]['function']) ? ' | line('.$trace[0]['line'].')' : null;

        response()->make([
            'path' => $path,
            'dd_data' => $args,
        ])->send();
        exit();
    }
}

if (! function_exists('setEnv')) {
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
}

if (! function_exists('checkIfFileExists')) {
    /**
     * this function to check if request has file
     */
    function checkIfFileExists($file, $name)
    {
        if (isset(request()->all()[$name])) {
            if (gettype(request()->all()[$name]) !== 'array') {
                if (! isset($file) || is_null($file) || ! request()->hasFile($name)) {
                    return response()->json("please make sure you store correct file.", Response::HTTP_BAD_REQUEST);
                }
            }
        }
    }
}

function dateFormat($date)
{
    return \Carbon\Carbon::parse($date)->toFormattedDateString();
}
