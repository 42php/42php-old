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
 * Gère les nombres
 *
 * Class Number
 * @package Core
 */
class                               Number {
    /**
     * Calcule un pourcentage
     *
     * @param float $full           Valeur haute
     * @param float $minus          Valeur basse
     * @param int $round            Chiffres après la virgule
     *
     * @return float                Pourcentage
     */
    public static function          percent($full, $minus, $round = 2) {
        Debug::trace();
        return round($minus / $full * 100, $round);
    }
}