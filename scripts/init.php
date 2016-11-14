<?php

if (!defined('NO_BUFFER'))
    ob_start();

/** Define the ROOT. Used in all the system to have the working directory. */
define('ROOT', realpath(__DIR__.'/../'));

/** If HTTP_HOST isn't defined, we are in CLI environnement. */
if (!isset($_SERVER['HTTP_HOST']))
    $_SERVER['HTTP_HOST'] = 'cli';

/** If we are in CLI environnement, we create a fake REQUEST_URI from the $argv variable. */
if (!isset($_SERVER['REQUEST_URI'])) {
    if (isset($argv)) {
        $p = [];
        foreach ($argv as $i => $a)
            if ($i >= 1) {
                $p[] = $a;
            }
        $_SERVER['REQUEST_URI'] = '/'.implode('/', $p);
    } else
        $_SERVER['REQUEST_URI'] = '/';
}

/** Call the autoloader. */
include_once __DIR__.'/autoload.php';
