<?php

// Start the session for user-related data like login state
session_start();

// Require necessary files (relative to index.php)
require '../app/core/Router.php';
require '../app/models/Model.php';
require '../app/controllers/Controller.php';
require '../app/controllers/MainController.php';
require '../app/controllers/UserController.php';
require '../app/controllers/RestaurantController.php';
require '../app/models/User.php';
require '../app/models/Restaurant.php';

// Load environment variables from the .env file
$env = parse_ini_file('../.env');

// Define constants for database configuration from .env file
define('DBNAME', $env['DBNAME']);
define('DBHOST', $env['DBHOST']);
define('DBUSER', $env['DBUSER']);
define('DBPASS', $env['DBPASS']);
define('DBDRIVER', 'mysql'); // Change if using a different database driver (e.g., pgsql)

// Set up other configurations
define('DEBUG', true); // Set to false in production for security

// Configure error reporting based on DEBUG setting
if (DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../logs/error.log'); // Log errors to a file
}

// Establish a database connection using PDO
try {
    $dsn = DBDRIVER . ':host=' . DBHOST . ';dbname=' . DBNAME;
    $pdo = new PDO($dsn, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception mode for errors

    // Make the PDO object available globally as a constant
    define('DB_CONNECTION', $pdo);
} catch (PDOException $e) {
    // Handle database connection errors
    die("Database connection failed: " . $e->getMessage());
}

// Initialize the Router and process the incoming request
$router = new \app\core\Router();
$router->match(); // Match the current request to the defined routes
