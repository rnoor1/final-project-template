<?php

namespace app\models;

abstract class Model {
    protected $db;
    protected $table;

    public function __construct($db) {
        $this->db = $db;
    }

    
    public function findAll() {
        $query = "SELECT * FROM $this->table";
        return $this->query($query);
    }

    
    public function findById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        return $this->query($query, ['id' => $id]);
    }

    
    protected function query($query, $data = []) {
        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
