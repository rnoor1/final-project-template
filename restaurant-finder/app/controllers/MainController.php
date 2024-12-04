<?php

namespace app\controllers;

class MainController extends Controller {
    
    
    public function homepage() {
        $pathToView = __DIR__ . '/../../public/views/main/homepage.html';
        $this->returnView($pathToView);
    }

    
    public function apiExample() {
        $data = [
            'status' => 'success',
            'message' => 'Welcome to the Restaurant Finder API!'
        ];
        $this->returnJSON($data);
    }
}
