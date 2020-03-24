<?php


use Illuminate\Support\Facades\Log;

if (!function_exists('pre')) {
    function pre()
    {
        $data = func_get_args();
        foreach ($data as $key => $val) {
            echo '<pre>';
            var_dump($val);
            echo '</pre>';
        }

    }
}

if (!function_exists('prend')) {
    function prend()
    {
        $data = func_get_args();
        foreach ($data as $key => $val) {
            echo '<pre>';
            var_dump($val);
            echo '</pre>';
        }
        exit();
    }
}


if (!function_exists('log_zip')) {
    function log_zip($str)
    {
        Log::channel('zip')->info($str);
    }
}
