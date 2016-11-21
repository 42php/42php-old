<?php

/**
 * Class SystemController
 */
class                                   SystemController extends \Core\Controller {

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

    /**
     * Redirige sur la home, selon la langue
     */
    public function                     redirectToLang() {
        \Core\Redirect::http(\Core\Argv::createUrl('home'));
    }

    /**
     * Affiche la vue d'un plugin
     */
    public function                     renderPluginTemplate() {
        global $argv;
        $a = array_slice($argv, 2);
        $plugin = $argv[1];
        $file = ROOT . '/core/Plugins/' . $plugin . '/' . implode('/', $a) . '.php';
        if (file_exists($file)) {
            include $file;
        }
        die();
    }
}