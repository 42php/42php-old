<?php

namespace                   Drivers\Database;

/**
 * Interface Factory
 * @package Drivers\Database
 */
interface                   Factory {
    public static function  getInstance();
    public function         close();
    public function         __get($k);
}