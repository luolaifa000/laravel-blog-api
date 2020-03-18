<?php



if (!function_exists('pre')) {
    function pre()
    {
        $data = func_get_args();
        foreach ($data as $key => $val) {
            echo '<pre>';
            print_r($val);
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
            print_r($val);
            echo '</pre>';
        }
        exit();
    }
}

