<?php

namespace app\models;

abstract class Model {
    protected $db;
    protected $table;

    public function __construct($db) {
        $this->db = $db;
    }

    // Find all records from the table
    public function findAll() {
        $query = "SELECT * FROM $this->table";
        return $this->query($query);
    }

    // Get a single record by ID
    public function findById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        return $this->query($query, ['id' => $id]);
    }

    // Execute a query
    protected function query($query, $data = []) {
        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
