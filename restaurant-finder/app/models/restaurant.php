<?php

namespace app\models;

class Restaurant extends Model {
    protected $table = 'restaurants';  // Define the table name for restaurants

    // Get all restaurants
    public function getAllRestaurants() {
        return $this->findAll();  // Inherited from Model.php
    }

    // Get restaurant details by ID
    public function getRestaurantById($id) {
        return $this->findById($id);  // Inherited from Model.php
    }

    // Add a new restaurant
    public function addRestaurant($name, $location, $cuisine) {
        $query = "INSERT INTO $this->table (name, location, cuisine) VALUES (:name, :location, :cuisine)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':cuisine', $cuisine);
        return $stmt->execute();
    }
}
