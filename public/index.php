<?php

/**
 * Call the initialization script
 */
include '../scripts/init.php';

$routes = \Core\JSON::toArray(ROOT.'/config/routes.json');

\Core\Conf::set('route', false);
$route = \Core\Argv::route($argv, $routes);
if (isset($route['route']))
    \Core\Conf::set('route', $route['route']);

\Core\Session::$apiMode = $route && isset($route['conf']['api']) && $route['conf']['api'];
\Core\Session::init();

include ROOT.'/scripts/i18n.php';

if (!$route) {
    $route = [
        'controller' => 'RootController@redirect',
        'params' => ''
    ];
}

echo \Core\Controller::run($route['controller'], $route['params']);