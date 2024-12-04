<?php

namespace app\controllers;

class MainController extends Controller {

    public function homepage() {
        $userAQModel = new \app\models\User();
        $data = $userAQModel->getSavedUserAQData();
    
        ob_start();
        //include './assets/views/main/homepage.html';
        include $_SERVER['DOCUMENT_ROOT'] . '/assets/views/main/homepage.html';

        $content = ob_get_clean();
    
        include $_SERVER['DOCUMENT_ROOT'] . '/assets/views/main/homepage.html';
        // Now pass the $data into your view
       // include './assets/views/main/homepage.php';  // If you have a .php version to handle data
        exit();
    }

    public function notFound() {
        http_response_code(404);
        echo json_encode(['error' => 'Page not found']);
        exit();
    }

}