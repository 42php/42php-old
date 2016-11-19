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
 * Génère et teste des chaînes blowfish
 *
 * Class Hash
 * @package Core
 */
class 								Hash {
    /**
     * Hash en blowfish une chaîne
     *
     * @param string $input         Chaîne à hasher
     * @param int $rounds           Nombre de passages
     *
     * @return string               Chaîne blowfish
     */
    public static function 			blowfish($input, $rounds = 7) {
        Debug::trace();
        $salt = "";
        $salt_chars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
        for ($i = 0; $i < 22; $i++) {
            $salt .= $salt_chars[array_rand($salt_chars)];
        }
        return crypt($input, sprintf('$2a$%02d$', $rounds) . $salt);
    }

    /**
     * Détermine si la chaîne saisie par l'utilisateur est similaire à la chaîne hashée
     *
     * @param string $entered       Chaîne saisie par l'utilisateur
     * @param string $original      Chaîne hashée
     *
     * @return bool                 TRUE si la chaîne est similaire, sinon FALSE
     */
    public static function 			same($entered, $original) {
        Debug::trace();
        return crypt($entered, $original) == $original;
    }
}