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

namespace                           Core;

/**
 * Gère la configuration du php.ini
 *
 * Class Ini
 * @package Core
 */
class 								Ini {
    /**
     * Convertit une taille textuelle en octets (ex: 1M -> 1024)
     *
     * @param int $val              La taille
     *
     * @return int                  La taille en octets
     */
    public static function 			bytes($val) {
        Debug::trace();
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        switch($last) {
            case 'g':
                $val *= 1024;
                break;
            case 'm':
                $val *= 1024;
                break;
            case 'k':
                $val *= 1024;
                break;
        }

        return $val;
    }

    /**
     * Lit une valeur du fichier php.ini
     *
     * @param string $field     Champ à lire
     *
     * @return string           Valeur
     */
    public static function 			get($field) {
        Debug::trace();
        return ini_get($field);
    }

    /**
     * Alias de Ini::bytes
     *
     * @param int $val              La taille
     *
     * @return int                  La taille en octets
     */
    public static function 			size($val) {
        Debug::trace();
        return Ini::bytes($val);
    }
}