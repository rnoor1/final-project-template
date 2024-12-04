<?php

namespace app\controllers;

use app\models\Restaurant;

class RestaurantController {
    
    private $restaurantModel;

    
    public function __construct() {
        $this->restaurantModel = new Restaurant(DB_CONNECTION);  // Pass the PDO connection
    }

   
    public function showRestaurants() {
        $restaurants = $this->restaurantModel->getAllRestaurants();  
        echo json_encode($restaurants);  
    }

    
    public function showRestaurantDetails($id) {
        $restaurant = $this->restaurantModel->getRestaurantById($id); 
        echo json_encode($restaurant);  
    }

    
    public function addRestaurant($name, $location, $cuisine) {
        $this->restaurantModel->addRestaurant($name, $location, $cuisine);  
    }
}
