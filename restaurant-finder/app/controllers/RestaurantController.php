<?php

namespace app\controllers;

use app\models\Restaurant;

class RestaurantController {
    
    private $restaurantModel;

    // Constructor to initialize the Restaurant model
    public function __construct() {
        $this->restaurantModel = new Restaurant(DB_CONNECTION);  // Pass the PDO connection
    }

    // Display all restaurants
    public function showRestaurants() {
        $restaurants = $this->restaurantModel->getAllRestaurants();  // Call the method from the Restaurant model to get all restaurants
        echo json_encode($restaurants);  // Return the restaurants as a JSON response
    }

    // Display a specific restaurant by ID
    public function showRestaurantDetails($id) {
        $restaurant = $this->restaurantModel->getRestaurantById($id);  // Call the method from the Restaurant model to get a single restaurant by ID
        echo json_encode($restaurant);  // Return restaurant details as JSON
    }

    // Add a new restaurant
    public function addRestaurant($name, $location, $cuisine) {
        $this->restaurantModel->addRestaurant($name, $location, $cuisine);  // Call the method from the Restaurant model to add a new restaurant
        echo json_encode(['message' => 'Restaurant added successfully']);  // Return a success message as JSON
    }
}
