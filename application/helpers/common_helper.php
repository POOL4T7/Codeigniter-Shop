<?php

if (!function_exists('js_escape')) {

    function js_escape($value)
    {
        return json_encode($value, JSON_HEX_TAG);
    }
}


if (!function_exists('json_print')) {

    function json_print($data)
    {
        echo json_encode($data, 555);
        die;
    }
}
