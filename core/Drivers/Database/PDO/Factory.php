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

namespace                       Drivers\Database\PDO;

/**
 * Gère la connexion à une base de données SQL via PDO
 *
 * Class Factory
 * @package Drivers\Database\PDO
 */
class                           Factory implements \Drivers\Database\Factory {
    /**
     * @var null|Factory $singleton Contient une instance singleton de la factory
     */
    private static              $singleton = null;

    /**
     * Retourne une instance singleton
     *
     * @return bool|Factory
     */
    public static function      getInstance() {
        if (is_null(self::$singleton)) {
            try {
                $pdo = new \PDO(
                    \Core\Conf::get('database.config.dsn', 'mysql:host=localhost;dbname=42php'),
                    \Core\Conf::get('database.config.user', 'root'),
                    \Core\Conf::get('database.config.pass', '')
                );
                $pdo->exec("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
                self::$singleton = new self($pdo);
            } catch (\PDOException $e) {
                return false;
            }
        }
        return self::$singleton;
    }

    /**
     * @var null|\PDO           Contient l'objet PDO
     */
    private                     $pdo = null;

    /**
     * Factory constructor.
     * @param \PDO $pdo
     */
    public function             __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Déconnecte PDO
     */
    public function             close() {
        $this->pdo = null;
        self::$singleton = null;
    }

    /**
     * Retourne une table
     *
     * @param string $k     Nom de la table
     * @return Collection
     */
    public function             __get($k) {
        return new Collection($this->pdo);
    }
}
