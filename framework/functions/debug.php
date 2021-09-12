<?php


function dd(...$vars) {
    dump(...$vars);
    die();
}

function dump(...$vars) {
    var_dump($vars);
    echo '<hr>';
}

function timeWork():float
{
    return round(microtime(1)-GF_START_TIME,2);
}