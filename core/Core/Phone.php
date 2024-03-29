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
 * Gère les numéros de téléphone
 *
 * Class Phone
 * @package Core
 */
class                           Phone {
    const                       MOBILE = 1;
    const                       FIXE = 2;

    /**
     * Détermine le type d'un numéro de téléphone
     *
     * @param string $phone     Numéro de téléphone
     * @param string $country   Pays
     *
     * @return bool|int         Phone::MOBILE si le numéro est celui d'un mobile
     *                          Phone::FIXE si le numéro est celui d'un fixe
     *                          FALSE si le numéro est invalide
     */
    public static function      getType($phone, $country = 'FR') {
        Debug::trace();
        try {
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            $number = $phoneUtil->parse($phone, $country);
            if (!$phoneUtil->isValidNumber($number))
                return false;
            $type = $phoneUtil->getNumberType($number);
            if ($type == \libphonenumber\PhoneNumberType::MOBILE)
                return self::MOBILE;
            return self::FIXE;
        } catch (\libphonenumber\NumberParseException $e) {
            return false;
        }
    }

    /**
     * Nettoie un numéro de téléphone
     *
     * @param string $phone     Numéro de téléphone
     * @param string $country   Pays du numéro
     *
     * @return bool|string      Numéro nettoyé (au format international) ou FALSE si invalide
     */
    public static function      clean($phone, $country = 'FR') {
        Debug::trace();
        try {
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            $number = $phoneUtil->parse($phone, $country);
            if (!$phoneUtil->isValidNumber($number))
                return false;
            return $phoneUtil->format($number, \libphonenumber\PhoneNumberFormat::E164);
        } catch (\libphonenumber\NumberParseException $e) {
            return false;
        }
    }

    /**
     * Nettoie un numéro de téléphone et le formatte au format national
     *
     * @param string $phone     Numéro de téléphone
     * @param string $country   Pays du numéro
     *
     * @return bool|string      Numéro nettoyé (au format national) ou FALSE si invalide
     */
    public static function      national($phone, $country = 'FR') {
        Debug::trace();
        try {
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            $number = $phoneUtil->parse($phone, $country);
            if (!$phoneUtil->isValidNumber($number))
                return false;
            return $phoneUtil->format($number, \libphonenumber\PhoneNumberFormat::NATIONAL);
        } catch (\libphonenumber\NumberParseException $e) {
            return false;
        }
    }
}

?>