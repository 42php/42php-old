<?php

namespace                       Core;

/**
 * Class Argv
 */
class 							Argv {
    /**
     * Lit l'URL pour en extraire les paramètres.
     * @param string $url   URL à traiter
     * @param int $offset   Nombre d'éléments à ignorer au début
     *
     * @return array        Le tableau d'arguments
     */
    public static function 		parse($url, $offset = 0) {
        $argv = array();
        $url = urldecode($url);
        $url = explode('?', $url);
        $url = explode('/', $url[0]);
        foreach ($url as $u)
            if (strlen(trim($u)))
                $argv[] = trim($u);
        while ($offset--)
            array_shift($argv);
        return $argv;
    }

    /**
     * Teste si la route matche l'URL fournie
     * @param string $url      URL courante
     * @param string $route    Route à tester
     *
     * @return array           Le résultat
     */
    private static function 	routeMatch($url, $route) {
        $tmp = array();
        preg_match_all('/(\{[a-z0-9\-\_]+\})/i', $route, $matches);
        foreach ($matches[0] as $k)
            $tmp[] = [substr($k, 1, strlen($k) - 2), ''];

        $originalRoute = $route;

        if (strstr($originalRoute, '*') !== false) {
            if (fnmatch($originalRoute, $url))
                return ['match' => true, 'params' => [], 'offset' => 0 ];
            return ['match' => false, 'params' => [], 'offset' => 0 ];
        }

        $route = preg_replace('/(\{[a-z0-9\-\_]+\}\?)/i', '([\w\.\-\_]*)', $route);
        $route = preg_replace('/(\{[a-z0-9\-\_]+\})/i', '([\w\.\-\_]+)', $route);
        $route = str_replace('/', '\/', $route);
        $route = '/^'.$route.'?$/i';
        $res = preg_match_all($route, $url, $matches);
        for ($i = 1; $i < sizeof($matches); $i++)
            if (isset($matches[$i][0]))
                $tmp[$i - 1][1] = $matches[$i][0];

        $params = array();
        foreach ($tmp as $t)
            $params[$t[0]] = $t[1];

        return ['match' => $res ? true : false, 'params' => $params, 'offset' => substr($originalRoute, -2) == '?/' ? 1 : 0 ];
    }

    /**
     * Effectue le routing.
     * Teste une à une les routes et trouve celle qui matche le mieux.
     *
     * @param array $argv               Tableau d'arguments
     * @param array $routes             Liste des routes (comme dans config/routes.json)
     * @param string $fieldToReturn     Le champ à retourner dans le résultat
     *
     * @return array|bool               Retourne la route sélectionnée, ou false si aucune route ne matche
     */
    public static function 		route($argv, $routes, $fieldToReturn = 'controller') {
        if (!sizeof($argv))
            $url = '/';
        else
            $url = '/'.implode('/', $argv).'/';
        $offset = -1;
        $toReturn = false;
        $lang = Conf::get('oldlang') != '' ? Conf::get('oldlang') : Conf::get('lang');

        foreach ($routes as $name => $r) {
            if (!isset($r['routes'][$lang]))
                continue;
            $route = $r['routes'][$lang];
            if (substr($route, -1) != '/')
                $route .= '/';
            $res = self::routeMatch($url, $route);
            if ($res['match']) {
                $potentialOffset = sizeof(self::parse($route)) - $res['offset'];
                if ($potentialOffset > $offset) {
                    $offset = $potentialOffset;
                    $toReturn = [
                        $fieldToReturn => $r[$fieldToReturn],
                        'params' => $res['params'],
                        'route' => array(
                            'params' => $res['params'],
                            'name' => $name
                        ),
                        'offset' => $offset
                    ];
                }
            }
        }
        return $toReturn;
    }

    /**
     * Effectue le routing, mais pour toutes les langues.
     * Teste une à une les routes et trouve celle qui matche le mieux.
     *
     * @param array $argv               Tableau d'arguments
     * @param array $routes             Liste des routes (comme dans config/routes.json)
     * @param string $fieldToReturn     Le champ à retourner dans le résultat
     *
     * @return array|bool               Retourne la route sélectionnée, ou false si aucune route ne matche
     */
    public static function 		globalRoute($argv, $routes, $fieldToReturn = 'controller') {
        if (!sizeof($argv))
            $url = '/';
        else
            $url = '/'.implode('/', $argv).'/';
        $offset = -1;
        $toReturn = false;
        foreach ($routes as $name => $r) {
            foreach ($r['routes'] as $lang => $route) {
                if (substr($route, -1) != '/')
                    $route .= '/';
                $res = self::routeMatch($url, $route);
                if ($res['match']) {
                    $potentialOffset = sizeof(self::parse($route)) - $res['offset'];
                    if ($potentialOffset > $offset) {
                        $offset = $potentialOffset;
                        $toReturn = [
                            $fieldToReturn => $r[$fieldToReturn],
                            'params' => $res['params'],
                            'route' => array(
                                'params' => $res['params'],
                                'name' => $name
                            ),
                            'offset' => $offset,
                            'lang' => $lang
                        ];
                    }
                }
            }
        }
        return $toReturn;
    }

    /**
     * Crée une URL absolue à partir d'une route et de ses paramètres
     *
     * @param string $name          Nom de la route
     * @param array $params         Paramètres à appliquer
     * @param string|bool $lang     Langue de la route. Si false, alors la langue courante sera sélectionnée.
     *
     * @return string               L'URL absolue
     */
    public static function 		createUrl($name, $params = [], $lang = false) {
        if (!$lang)
            $lang = Conf::get('lang');
        $routes = json_decode(file_get_contents(ROOT.'/config/routes.json'), true);
        if (!isset($routes[$name]['routes'][$lang]))
            return '/';
        $url = str_replace('?', '', $routes[$name]['routes'][$lang]);
        foreach ($params as $k => $v)
            $url = str_replace('{'.$k.'}', $v, $url);
        return $url;
    }
}