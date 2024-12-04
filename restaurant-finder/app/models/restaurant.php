<?php

namespace app\models;

use PDO;

class Restaurant {

    private $db;

    public function __construct() {
        $this->db = DB_CONNECTION; // Use the globally defined PDO instance
    }

    // Fetch all restaurants
    public function getAllRestaurants() {
        $query = "SELECT * FROM restaurants";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a single restaurant by ID
    public function getRestaurantById($id) {
        $query = "SELECT * FROM restaurants WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch reviews for a specific restaurant
    public function getReviewsByRestaurant($restaurantId) {
        $query = "SELECT * FROM reviews WHERE restaurant_id = :restaurant_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':restaurant_id', $restaurantId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Save a new restaurant
    public function saveRestaurant($data) {
        $query = "INSERT INTO restaurants (name, address, phone, cuisine) VALUES (:name, :address, :phone, :cuisine)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':address', $data['address']);
        $stmt->bindValue(':phone', $data['phone']);
        $stmt->bindValue(':cuisine', $data['cuisine']);
        return $stmt->execute();
    }

    // Update restaurant details
    public function updateRestaurant($id, $data) {
        $query = "UPDATE restaurants SET name = :name, address = :address, phone = :phone, cuisine = :cuisine WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':address', $data['address']);
        $stmt->bindValue(':phone', $data['phone']);
        $stmt->bindValue(':cuisine', $data['cuisine']);
        return $stmt->execute();
    }

    // Delete a restaurant
    public function deleteRestaurant($id) {
        $query = "DELETE FROM restaurants WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
