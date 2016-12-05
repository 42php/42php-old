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
     * Liste les plugins installés
     *
     * @return array
     */
    public static function      listPlugins() {
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

        return $ret;
    }
}