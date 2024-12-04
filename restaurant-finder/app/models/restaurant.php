<?php

namespace app\models;

class Restaurant extends Model {
    protected $table = 'restaurants';  

    
    public function getAllRestaurants() {
        return $this->findAll();  
    }

    
    public function getRestaurantById($id) {
        return $this->findById($id);  
    }

    
    public function addRestaurant($name, $location, $cuisine) {
        $query = "INSERT INTO $this->table (name, location, cuisine) VALUES (:name, :location, :cuisine)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':cuisine', $cuisine);
        return $stmt->execute();
    }
}
