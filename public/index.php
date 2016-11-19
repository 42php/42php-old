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

include ROOT.'/scripts/i18n.php';

if (!$route) {
    $route = [
        'controller' => 'RootController@redirect',
        'params' => ''
    ];
}

if (\Core\Conf::get('debug', false) && isset($_GET['trace']))
    echo \Core\Controller::run($route['controller'], $route['params']);