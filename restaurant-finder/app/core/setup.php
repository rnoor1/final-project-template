<?php


session_start();


require '../app/core/Router.php';
require '../app/models/Model.php';
require '../app/controllers/Controller.php';
require '../app/controllers/MainController.php';
require '../app/controllers/UserController.php';
require '../app/controllers/RestaurantController.php';
require '../app/models/User.php';
require '../app/models/Restaurant.php';


$env = parse_ini_file('../.env');


define('DBNAME', $env['DBNAME']);
define('DBHOST', $env['DBHOST']);
define('DBUSER', $env['DBUSER']);
define('DBPASS', $env['DBPASS']);
define('DBDRIVER', 'mysql'); 


define('DEBUG', true); 


if (DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../logs/error.log'); // Log errors to a file
}


try {
    $dsn = DBDRIVER . ':host=' . DBHOST . ';dbname=' . DBNAME;
    $pdo = new PDO($dsn, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception mode for errors

    
    define('DB_CONNECTION', $pdo);
} catch (PDOException $e) {
    
    die("Database connection failed: " . $e->getMessage());
}


$router = new \app\core\Router();
$router->match(); 
