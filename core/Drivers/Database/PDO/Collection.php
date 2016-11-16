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
 * Class Collection
 * @package Drivers\Database\PDO
 */
class                           Collection implements \Drivers\Database\Collection {
    /**
     * @var null|\PDO           Contient l'objet PDO
     */
    private                     $pdo = null;

    /**
     * Collection constructor.
     * @param \PDO $pdo
     */
    public function             __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Insère un document en base de données
     *
     * @param $data
     * @return mixed
     */
    public function insert(&$data)
    {
        // TODO: Implement insert() method.
    }

    /**
     * Met à jour un ou plusieurs documents
     *
     * @param array $clause
     * @param array $data
     * @param array $options
     * @return mixed
     */
    public function update($clause = [], $data = [], $options = [])
    {
        // TODO: Implement update() method.
    }

    /**
     * Sauvegarde un document (effectue un upsert)
     *
     * @param $data
     * @return mixed
     */
    public function save(&$data)
    {
        // TODO: Implement save() method.
    }

    /**
     * Trouve une liste de documents
     *
     * @param array $clause
     * @param array $values
     * @return mixed
     */
    public function find($clause = [], $values = [])
    {
        // TODO: Implement find() method.
    }

    /**
     * Trouve un document
     *
     * @param array $clause
     * @param array $values
     * @return mixed
     */
    public function findOne($clause = [], $values = [])
    {
        // TODO: Implement findOne() method.
    }

    /**
     * Supprime un ou plusieurs documents
     *
     * @param array $clause
     * @param array $options
     * @return mixed
     */
    public function remove($clause = [], $options = [])
    {
        // TODO: Implement remove() method.
    }

}