<?php

if(!function_exists('dd')) {
    function dd(...$vars) {
        dump(...$vars);
        die();
    }
}

if(!function_exists('dump')) {
    function dump(...$vars) {
        var_export($vars);
        echo '<hr>';
    }
}