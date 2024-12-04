<?php

namespace app\models;

//using the database class namespace
use app\models\Model;

class Review extends Model {

    /**
     * Get all reviews for a specific restaurant.
     */
    public function getReviewsByRestaurant($restaurantId) {
        $query = "SELECT * FROM reviews WHERE restaurant_id = :restaurantId";
        return $this->fetchAllWithParams($query, ['restaurantId' => $restaurantId]);
    }

    /**
     * Get all reviews submitted by a specific user.
     */
    public function getReviewsByUser($userName) {
        $query = "SELECT * FROM reviews WHERE user_name LIKE :userName";
        return $this->fetchAllWithParams($query, ['userName' => '%' . $userName . '%']);
    }

    /**
     * Save a new review for a restaurant.
     */
    public function saveReview($inputData) {
        $query = "INSERT INTO reviews (user_name, restaurant_id, review_message, rating) 
                  VALUES (:userName, :restaurantId, :reviewMessage, :rating);";
        
        try {
            $this->query($query, $inputData);
            return ['success' => 'Review submitted
