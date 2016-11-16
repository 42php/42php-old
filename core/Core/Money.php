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

namespace                   Core;

/**
 * Class Money
 */
class                       Money {
    /**
     * Arrondit une variable sensée contenir une donnée financière
     *
     * @param float $amount         Montant
     *
     * @return float                Montant arrondi à 2 chiffres après la virgule
     */
    public static function  round($amount) {
        return round(floatval(str_replace(',', '.', $amount)), 2);
    }

    /**
     * Calcule le pourcentage de réduction dont a bénéficié le client
     *
     * @param float $full       Prix normal
     * @param float $semi       Prix payé
     *
     * @return float            Pourcentage de réduction
     */
    public static function  discountPercent($full, $semi) {
        $full = self::round($full);
        $semi = self::round($semi);

        if ($full == 0)
            return 0;

        return round(($full - $semi) * 100 / $full, 2);
    }
}