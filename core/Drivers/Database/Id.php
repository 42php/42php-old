<?php

namespace                       Drivers\Database;

/**
 * Gère les identifiants de documents dans les drivers
 *
 * Interface Id
 * @package Drivers\Database
 */
interface                       Id {
    public static function      format($id);
}