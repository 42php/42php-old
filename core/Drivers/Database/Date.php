<?php

namespace                       Drivers\Database;

/**
 * Gère les dates dans les drivers
 *
 * Interface Date
 * @package Drivers\Database
 */
interface                       Date {
    public static function      format($timestamp);
}