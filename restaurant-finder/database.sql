CREATE DATABASE restaurant_finder;

USE restaurant_finder;

CREATE TABLE restaurants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    cuisine VARCHAR(100),
    address VARCHAR(255),
    phone VARCHAR(50),
    menu JSON
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255)
);
``
