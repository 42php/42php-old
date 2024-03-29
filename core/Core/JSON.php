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
 * Class JSON
 */
class 							JSON {
    /**
     * Charge un fichier JSON.
     *
     * @param string $url   Chemin du fichier
     *
     * @return string       Contenu du fichier
     */
    public static function      _get($url) {
        return @file_get_contents($url);
    }

    /**
     * Décode le fichier JSON sous forme d'objet
     *
     * @param string $url       Chemin du fichier
     *
     * @return null|object      Objet JSON ou NULL.
     */
    public static function      toObject($url) {
        Debug::trace();
        return json_decode(self::_get($url), false);
    }

    /**
     * Décode le fichier JSON sous forme de tableau associatif
     *
     * @param string $url       Chemin du fichier
     *
     * @return null|array       Objet JSON sous forme de tableau associatif, ou NULL.
     */
    public static function      toArray($url) {
        Debug::trace();
        return json_decode(self::_get($url), true);
    }

    /**
     * Lit un fichier JSON, le décode, et renvoie son contenu.
     *
     * @param string $url       Chemin du fichier
     * @param bool $asObject    Détermine si on doit retourner sous forme d'objet ou de tableau associatif
     *
     * @return array|object|null Objet JSON décodé
     */
    public static function      parse($url, $asObject = false) {
        Debug::trace();
        return $asObject ? self::toObject($url) : self::toArray($url);
    }

    /**
     * Détermine si une chaîne est du JSON
     *
     * @param string $string    Chaîne de caractères à tester
     * @return bool             TRUE si la chaîne est du JSON
     */
    public static function      is($string) {
        Debug::trace();
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

?>