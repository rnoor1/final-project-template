<?php

namespace app\controllers;

use app\models\Restaurant;

class RestaurantController extends Controller {

    // Method to fetch all restaurants
    public function showRestaurants() {
        $restaurant = new Restaurant();
        $restaurants = $restaurant->getAllRestaurants(); // Fetch all restaurants

        if (empty($restaurants)) {
            $this->returnJSON(['message' => 'No restaurants available']); // If no data, return a message
        } else {
            $this->returnJSON($restaurants); // Return the list of restaurants as JSON
        }
    }

    // Method to fetch a single restaurant's details by ID
    public function showRestaurantDetails($id) {
        $restaurant = new Restaurant();
        $restaurantDetails = $restaurant->getRestaurantById($id); // Fetch restaurant details by ID

        if (empty($restaurantDetails)) {
            $this->returnJSON(['message' => 'Restaurant not found']); // If no data, return a message
        } else {
            $this->returnJSON($restaurantDetails); // Return the restaurant details as JSON
        }
    }

    // Method to fetch restaurant reviews by restaurant ID
    public function showReviews($restaurantId) {
        $restaurant = new Restaurant();
        $reviews = $restaurant->getReviewsByRestaurant($restaurantId); // Fetch reviews for the specific restaurant

        if (empty($reviews)) {
            $this->returnJSON(['message' => 'No reviews available for this restaurant']); // If no reviews, return a message
        } else {
            $this->returnJSON($reviews); // Return reviews data as JSON
        }
    }
}


