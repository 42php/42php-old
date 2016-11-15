<?php

namespace                           Core;

/**
 * Gère les requêtes sur la base de données
 *
 * Class Db
 * @package Core
 */
class                               Db {
    /**
     * Appelle la Factory du driver configuré. (\Drivers\Database\nomDuDriver\Factory::getInstance())
     *
     * @return mixed                L'instance de base de données
     */
    public static function          getInstance() {
        $factory = '\Drivers\Database\\'. Conf::get('database.type', 'PDO') .'\\Factory';
        if (class_exists($factory))
            return $factory::getInstance();
        return false;
    }

    public static function          date($timestamp) {
        $factory = '\Drivers\Database\\'. Conf::get('database.type', 'PDO') .'\\Date';
        if (class_exists($factory))
            return $factory::format($timestamp);
        return false;
    }
}