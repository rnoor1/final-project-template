<?php

namespace app\models;

use PDO;
use PDOException;

abstract class Model {
    protected $db;

    public function __construct() {
        // Initialize the database connection
        $this->connectToDatabase();
    }

    /**
     * Connect to the database using the constants defined in setup.php
     */
    private function connectToDatabase() {
        try {
            $dsn = DBDRIVER . ":host=" . DBHOST . ";dbname=" . DBNAME;
            $this->db = new PDO($dsn, DBUSER, DBPASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Error mode
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Default fetch mode
        } catch (PDOException $e) {
            // Handle connection error
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Execute a query with optional parameters and return the statement
     *
     * @param string $query - The SQL query
     * @param array $params - Optional query parameters
     * @return PDOStatement
     */
    protected function executeQuery($query, $params = []) {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Fetch all results for a query
     *
     * @param string $query - The SQL query
     * @param array $params - Optional query parameters
     * @return array
     */
    protected function fetchAll($query, $params = []) {
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetchAll();
    }

    /**
     * Fetch a single result for a query
     *
     * @param string $query - The SQL query
     * @param array $params - Optional query parameters
     * @return array|false
     */
    protected function fetchOne($query, $params = []) {
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetch();
    }

    /**
     * Insert data into a table
     *
     * @param string $table - Table name
     * @param array $data - Associative array of column names and values
     * @return int - ID of the inserted row
     */
    protected function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $this->executeQuery($query, $data);
        return $this->db->lastInsertId();
    }

    /**
     * Update data in a table
     *
     * @param string $table - Table name
     * @param array $data - Associative array of column names and values
     * @param string $condition - WHERE condition
     * @param array $params - Parameters for the WHERE condition
     * @return int - Number of affected rows
     */
    protected function update($table, $data, $condition, $params = []) {
        $setClause = implode(", ", array_map(fn($col) => "$col = :$col", array_keys($data)));
        $query = "UPDATE $table SET $setClause WHERE $condition";
        return $this->executeQuery($query, array_merge($data, $params))->rowCount();
    }

    /**
     * Delete data from a table
     *
     * @param string $table - Table name
     * @param string $condition - WHERE condition
     * @param array $params - Parameters for the WHERE condition
     * @return int - Number of affected rows
     */
    protected function delete($table, $condition, $params = []) {
        $query = "DELETE FROM $table WHERE $condition";
        return $this->executeQuery($query, $params)->rowCount();
    }
}
