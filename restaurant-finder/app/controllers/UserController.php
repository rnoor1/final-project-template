<?php

namespace app\controllers;

use app\models\User;

class UserController extends Controller {
    
    // Show the registration page
    public function showRegisterForm() {
        $this->returnView('users/register.html');
    }

    // Show the login page
    public function showLoginForm() {
        $this->returnView('users/login.html');
    }

    // Register a new user
    public function registerUser() {
        // Collect POST data from the form
        $username = $_POST['username'] ?? null;
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $confirmPassword = $_POST['confirm_password'] ?? null;
        $errors = [];

        // Validate form data
        if (!$username) {
            $errors['username'] = 'Username is required';
        }

        if (!$email) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }

        if (!$password) {
            $errors['password'] = 'Password is required';
        } elseif ($password !== $confirmPassword) {
            $errors['confirm_password'] = 'Passwords do not match';
        }

        // If errors exist, return them as JSON
        if (count($errors)) {
            http_response_code(400);
            echo json_encode($errors);
            exit();
        }

        // Sanitize inputs
        $username = htmlspecialchars($username);
        $email = htmlspecialchars($email);
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);  // Hash password for security

        // Save the user to the database
        $userModel = new User();
        $user = $userModel->register($username, $email, $passwordHash);

        if ($user) {
            echo json_encode(['success' => 'Registration successful']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Registration failed. Please try again.']);
        }

        exit();
    }

    // User login
    public function loginUser() {
        // Collect POST data from the form
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $errors = [];

        // Validate form data
        if (!$email) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }

        if (!$password) {
            $errors['password'] = 'Password is required';
        }

        // If errors exist, return them as JSON
        if (count($errors)) {
            http_response_code(400);
            echo json_encode($errors);
            exit();
        }

        // Sanitize inputs
        $email = htmlspecialchars($email);

        // Check if the user exists in the database
        $userModel = new User();
        $user = $userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // User successfully logged in (session handling can be added here)
            $_SESSION['user_id'] = $user['id'];  // Example session creation
            echo json_encode(['success' => 'Login successful']);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
        }

        exit();
    }

    // Show the user profile page (or dashboard)
    public function showUserProfile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $userModel = new User();
        $userData = $userModel->getUserById($_SESSION['user_id']);

        if ($userData) {
            $this->returnView('users/profile.html', ['user' => $userData]);
        } else {
            echo json_encode(['error' => 'User not found']);
        }

        exit();
    }

    // Logout the user
    public function logoutUser() {
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }
}
