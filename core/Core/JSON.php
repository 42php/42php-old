<?php

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
        return $asObject ? self::toObject($url) : self::toArray($url);
    }
}

?>