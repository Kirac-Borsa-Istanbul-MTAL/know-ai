<?php

function get_base_path() {
    $script_name = $_SERVER['SCRIPT_NAME'];
    $base_path = dirname($script_name);

    if ($base_path === '/' || $base_path === '\\') {
        $base_path = '';
    }
    return $base_path;
}

function url($path = '') {
    $base_path = get_base_path();
    $path = ltrim($path, '/');
    return rtrim($base_path, '/') . '/' . $path;
}


?>