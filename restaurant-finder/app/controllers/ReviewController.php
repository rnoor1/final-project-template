<?php

namespace app\controllers;

use app\models\Review;

class ReviewController extends Controller 
{
    /**
     * Validate restaurant review input data.
     */
    public function validateReview($inputData) {
        $errors = [];
        $userName = $inputData['userName'];
        $restaurantId = $inputData['restaurantId'];
        $reviewMessage = $inputData['reviewMessage'];
        $rating = $inputData['rating'];

        // Validate user name
        if ($userName) {
            $userName = htmlspecialchars($userName, ENT_QUOTES|ENT_HTML5, 'UTF-8', true);
            if (strlen($userName) < 2) {
                $errors['userNameShort'] = 'User name is too short';
            }
        } else {
            $errors['requiredUserName'] = 'User name is required';
        }

        // Validate restaurant ID
        if (!$restaurantId || !is_numeric($restaurantId)) {
            $errors['invalidRestaurantId'] = 'Invalid restaurant ID';
        }

        // Validate review message
        if ($reviewMessage) {
            $reviewMessage = htmlspecialchars($reviewMessage, ENT_QUOTES|ENT_HTML5, 'UTF-8', true);
            if (strlen($reviewMessage) < 10) {
                $errors['reviewMessageShort'] = 'Review message is too short, add more details';
            }
        } else {
            $errors['requiredReviewMessage'] = 'Review message is required';
        }

        // Validate rating
        if ($rating && is_numeric($rating) && $rating >= 1 && $rating <= 5) {
            $rating = (int)$rating;
        } else {
            $errors['invalidRating'] = 'Rating should be a number between 1 and 5';
        }

        if (count($errors)) {
            http_response_code(400);
            echo json_encode($errors);
            exit();
        }

        return [
            'userName' => $userName,
            'restaurantId' => $restaurantId,
            'reviewMessage' => $reviewMessage,
            'rating' => $rating
        ];
    }

    /**
     * Get all reviews for a specific restaurant.
     */
    public function getReviewsByRestaurant($restaurantId) {
        $reviewModel = new Review();
        header("Content-Type: application/json");
        $reviews = $reviewModel->getReviewsByRestaurant($restaurantId);

        echo json_encode($reviews);
        exit();
    }

    /**
     * Get all reviews by a specific user.
     */
    public function getReviewsByUser($userName) {
        $reviewModel = new Review();
        header("Content-Type: application/json");
        $reviews = $reviewModel->getReviewsByUser($userName);

        echo json_encode($reviews);
        exit();
    }

    /**
     * Save a new review.
     */
    public function saveReview() {
        $inputData = [
            'userName' => $_POST['userName'] ? $_POST['userName'] : false,
            'restaurantId' => $_POST['restaurantId'] ? $_POST['restaurantId'] : false,
            'reviewMessage' => $_POST['reviewMessage'] ? $_POST['reviewMessage'] : false,
            'rating' => $_POST['rating'] ? $_POST['rating'] : false,
        ];

        $reviewData = $this->validateReview($inputData);

        $review = new Review();
        $review->saveReview([
            'userName' => $reviewData['userName'],
            'restaurantId' => $reviewData['restaurantId'],
            'reviewMessage' => $reviewData['reviewMessage'],
            'rating' => $reviewData['rating'],
        ]);

        http_response_code(200);
        echo json_encode([
            'success' => true
        ]);
        exit();
    }

    /**
     * View for displaying all reviews for a restaurant.
     */
    public function restaurantReviewsView($restaurantId) {
        include '../public/assets/views/reviews/restaurantReviewsView.php';
        exit();
    }
}
