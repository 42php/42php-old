<?php
/**
 * LICENSE: This source file is subject to version 3.0 of the GPL license
 * that is available through the world-wide-web at the following URI:
 * https://www.gnu.org/licenses/gpl-3.0.fr.html (french version).
 *
 * @author      Guillaume Gagnaire <contact@42php.com>
 * @link        https://www.github.com/42php/42php
 * @license     https://www.gnu.org/licenses/gpl-3.0.fr.html GPL
 */

namespace                       Core;

/**
 * Gère l'exécution de plugins
 *
 * Class Plugin
 * @package Core
 */
class                           Plugin {
    /**
     * Rend la vue d'un plugin
     *
     * @param string $name      Nom du plugin
     * @param array $params     Paramètres à passer au plugin
     * @return bool|string      Code HTML
     */
    public static function      render($name, $params = []) {
        $className = '\\Plugins\\' . $name . '\\Factory';
        if (!class_exists($className))
            return false;
        $o = $className::getInstance();
        return $o->render($params);
    }

    /**
     * @var bool|array $pluginList Liste des plugins (cache singleton)
     */
    private static              $pluginList = false;

    /**
     * Liste les plugins installés
     *
     * @return array
     */
    public static function      listPlugins() {
        if (self::$pluginList !== false)
            return self::$pluginList;

        $ret = [];

        $dirname = ROOT . '/core/Plugins/';
        if ($handle = opendir($dirname)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != ".." && is_dir($dirname . $entry)) {
                    $ret[] = $entry;
                }
            }
            closedir($handle);
        }

        self::$pluginList = $ret;

        return $ret;
    }

    /**
     * Charge les endpoints Api des plugins
     */
    public static function      loadApiEndpoints() {
        $plugins = self::listPlugins();

        foreach ($plugins as $pluginName) {
            $className = '\\Plugins\\' . $pluginName . '\\Api';
            if (!class_exists($className))
                continue;
            if (method_exists($className, 'load'))
                $className::load();
        }
    }
}