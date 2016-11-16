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
 * Gère l'exécution de scripts en ligne de commande
 *
 * Class Cli
 * @package Core
 */
class                           Cli {
    /**
     * Détermine si le script courant est exécuté depuis le bash
     *
     * @return bool
     */
    public static function      is() {
        return $_SERVER['HTTP_HOST'] == 'cli';
    }

    /**
     * Force le système à croire que le script courant est exécuté depuis le bash
     */
    public static function      force() {
        $_SERVER['HTTP_HOST'] = 'cli';
    }
}