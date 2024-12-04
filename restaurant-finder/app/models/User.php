<?php

namespace app\controllers;

use app\models\User;

class UserController extends Controller {

    
    public function loginPage() {
        $pathToView = __DIR__ . '/../../public/views/users/login.html';
        $this->returnView($pathToView);
    }

    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header('Location: ?route=home');
                exit();
            } else {
                $this->returnView(__DIR__ . '/../../public/views/users/login.html');
                echo "<script>alert('Invalid credentials. Please try again.');</script>";
            }
        }
    }

    
    public function registerPage() {
        $pathToView = __DIR__ . '/../../public/views/users/register.html';
        $this->returnView($pathToView);
    }

    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($name && $email && $password) {
                $userModel = new User();
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $result = $userModel->createUser($name, $email, $hashedPassword);

                if ($result) {
                    header('Location: ?route=users/login');
                    exit();
                } else {
                    echo "<script>alert('Registration failed. Email might already be in use.');</script>";
                }
            } else {
                echo "<script>alert('All fields are required.');</script>";
            }
        }
    }

    
    public function logout() {
        session_destroy();
        header('Location: ?route=users/login');
        exit();
    }
}
