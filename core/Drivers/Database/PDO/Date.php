<?php

namespace                   Drivers\Database\PDO;

/**
 * Gère les dates sous PDO
 *
 * Class Date
 * @package Drivers\Database\PDO
 */
class                       Date implements \Drivers\Database\Date {
    /**
     * Formatte une date pour le SQL
     *
     * @param int $timestamp        Timestamp
     * @return string               La date formattée Y-m-d H:i:s
     */
    public static function  format($timestamp) {
        return date('Y-m-d H:i:s', $timestamp);
    }
}