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
 * Gère les dates
 *
 * Class Date
 * @package Core
 */
class                           Date {
    /**
     * Retourne le mois, textuel et traduit.
     *
     * @param $nb           Le numéro du mois (0-11)
     *
     * @return string       Le nom du mois en textuel
     */
    public static function      month($nb) {
        Debug::trace();
        $months = [
            _t("Janvier"),
            _t("Février"),
            _t("Mars"),
            _t("Avril"),
            _t("Mai"),
            _t("Juin"),
            _t("Juillet"),
            _t("Août"),
            _t("Septembre"),
            _t("Octobre"),
            _t("Novembre"),
            _t("Décembre")
        ];

        return $months[intval($nb)];
    }

    /**
     * Retourne la date en textuel
     *
     * @param mixed $date           La date, en timestamp ou au format compatible avec strtotime()
     * @param bool $hourmin         Ajoute l'heure et les minutes après la date
     * @param bool $sec             Ajout également les secondes
     *
     * @return string               La date
     */
    public static function      textual($date, $hourmin = false, $sec = false) {
        Debug::trace();
        if (!is_int($date))
            $date = strtotime($date);

        $d = [
            date('d', $date),
            self::month(intval(date('n', $date)) - 1),
            date('Y', $date)
        ];

        if ($hourmin && !$sec)
            $d[] = date('H:i');
        if ($hourmin && $sec)
            $d[] = date('H:i:s');

        return implode(' ', $d);
    }

    /**
     * Formalise une date au format ISO.
     *
     * Comprend actuellement :
     *
     * Dates :
     * <ul>
     *    <li>yyyy-mm-dd
     *    <li>yyyymmdd
     *    <li>dd/mm/yyyy
     * </ul>
     *
     * Heures :
     * <ul>
     *    <li>12:42:00
     *    <li>12:42
     *    <li>12h42
     * </ul>
     *
     * @param string $date      Date à standardiser
     *
     * @return string           Date formattée en ISO
     */
    public static function      toISO($date) {
        Debug::trace();
        $date = str_replace(['T', 'Z'], ' ', $date);
        $date = explode(' ', $date);
        if (sizeof($date) == 1)
            $date[] = '00:00:00';
        list($date, $hour) = $date;
        if (preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/', $date))
            $date = implode('-', array_reverse(explode('/', $date)));
        if (preg_match('/^[0-9]{8}$/', $date))
            $date = substr($date, 0, 4).'-'.substr($date, 4, 2).'-'.substr($date, 6, 2);
        if (preg_match('/^[0-9]{2}:[0-9]{2}$/', $hour))
            $hour .= ':00';
        if (preg_match('/^[0-9]{2}h[0-9]{2}$/i', $hour))
            $hour = str_replace('h', ':', strtolower($hour)).':00';
        return $date . ' ' . $hour;
    }
}