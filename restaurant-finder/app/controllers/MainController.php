<?php

namespace app\controllers;

class MainController extends Controller {
    
    // Render the homepage
    public function homepage() {
        $pathToView = __DIR__ . '/../../public/views/main/homepage.html';
        $this->returnView($pathToView);
    }

    // Example: Handle an API request and return JSON
    public function apiExample() {
        $data = [
            'status' => 'success',
            'message' => 'Welcome to the Restaurant Finder API!'
        ];
        $this->returnJSON($data);
    }
}
