<?php

namespace                       Drivers\Database\PDO;

/**
 * Class Collection
 * @package Drivers\Database\PDO
 */
class                           Collection implements \Drivers\Database\Collection {
    private                     $pdo = null;

    /**
     * Collection constructor.
     * @param PDO $pdo
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
    public function insert($data)
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
    public function save($data)
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