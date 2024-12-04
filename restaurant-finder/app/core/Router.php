<?php

namespace app\core;

use app\controllers\MainController;
use app\controllers\UserController;
use app\controllers\RestaurantController;

class Router {

    public $urlArray;

    public function __construct() {
        $this->urlArray = $this->routeSplit();
        $this->handleMainRoutes();      // Handle homepage route
        $this->handleUserRoutes();      // Handle user-related API routes
        $this->handleRestaurantRoutes(); // Handle restaurant-related API routes
        $this->handleViewRoutes();      // Handle HTML view routes
    }

    // Split the URL into an array for easy parsing
    protected function routeSplit() {
        $removeQueryParams = strtok($_SERVER["REQUEST_URI"], '?'); // Remove query string
        return explode("/", $removeQueryParams);
    }

    // Handle the main route (homepage)
    protected function handleMainRoutes() {
        if ($this->urlArray[1] === '' && $_SERVER['REQUEST_METHOD'] === 'GET') {
            $mainController = new MainController();
            $mainController->homepage();
        }
    }

    // Handle user-related routes (GET, POST, DELETE)
    protected function handleUserRoutes() {
        if ($this->urlArray[1] === 'api' && $this->urlArray[2] === 'users') {
            $userController = new UserController();

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $userController->profile(); // Fetch user profile
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($this->urlArray[3] === 'register') {
                    $userController->register(); // Register user
                } elseif ($this->urlArray[3] === 'login') {
                    $userController->login(); // Log in user
                }
            } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                $userController->deleteUser(); // Delete user
            }
        }
    }

    // Handle restaurant-related routes
    protected function handleRestaurantRoutes() {
        if ($this->urlArray[1] === 'api' && $this->urlArray[2] === 'restaurants') {
            $restaurantController = new RestaurantController();

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (!isset($this->urlArray[3])) {
                    $restaurantController->showRestaurants(); // Fetch all restaurants
                } elseif ($this->urlArray[3] === 'reviews' && isset($this->urlArray[4])) {
                    $restaurantController->showReviews($this->urlArray[4]); // Fetch reviews for a specific restaurant
                } elseif (is_numeric($this->urlArray[3])) {
                    $restaurantController->showRestaurantDetails($this->urlArray[3]); // Fetch specific restaurant details
                }
            }
        }
    }

    // Handle HTML view routes (e.g., views for restaurants or users)
    protected function handleViewRoutes() {
        if ($this->urlArray[1] === 'views' && $this->urlArray[2] === 'restaurants') {
            if ($this->urlArray[3] === 'listView.html') {
                // Include the restaurant list view HTML
                $filePath = __DIR__ . '/../../public/assets/views/restaurants/listView.html';
                if (file_exists($filePath)) {
                    readfile($filePath);
                } else {
                    echo "Error: listView.html not found.";
                }
                exit();
            }

            if ($this->urlArray[3] === 'detailsView.html') {
                // Include the restaurant details view HTML
                $filePath = __DIR__ . '/../../public/assets/views/restaurants/detailsView.html';
                if (file_exists($filePath)) {
                    readfile($filePath);
                } else {
                    echo "Error: detailsView.html not found.";
                }
                exit();
            }
        }
    }
}
