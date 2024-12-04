<?php

namespace app\models;

use PDO;

class User {

    public function registerUser($username, $email, $password) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = DB_CONNECTION->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return false; // User already exists
        }

        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = DB_CONNECTION->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = DB_CONNECTION->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
