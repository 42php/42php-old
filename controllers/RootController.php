<?php

/**
 * Class RootController
 */
class                                   RootController extends \Core\Controller {

    /**
     * Gère les URL inconnues
     */
    public function                     redirect() {
        global $argv;
        $route = \Core\Argv::globalRoute($argv, \Core\JSON::toArray(ROOT.'/config/routes.json'));
        if ($route && $route['controller'] != 'RootController@redirect') {
            switch (\Core\Conf::get('i18n.source.prefer', 'browser')) {
                case 'route':
                    \Core\i18n::setLang($route['lang'], true);
                    return \Core\Controller::run($route['controller'], $route['params']);
                    break;
                case 'browser':
                default:
                    $url = \Core\Argv::createUrl($route['route']['name'], $route['route']['params']);
                    if (sizeof($_GET))
                        $url .= '?'.http_build_query($_GET);
                    \Core\Redirect::http($url);
                    break;
            }
        }
        \Core\Http::responseCode(404);
        return '';
    }
}