<?php
require_once __DIR__ . "/../../../models/verification_tokens_users.php";
require_once __DIR__ . "/../../../models/users.php";
require_once __DIR__ . "/../../../models/transactions.php";


class ConfirmSignupHandler {
    public static function handleRequest() {

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return self::handleResponse(false,'invalid request method');
        }

        $token = $_GET['token'];
        if (!$token) {
            return self::handleResponse(false, 'token not found');
        }
        
        $user_id = Verification_tokens_user::verifyToken($token);
        if (!$user_id) {
            return self::handleResponse(false, 'invalid token');
        }
        User::verifyUsers($user_id);
        self::handleResponse(true, 'user verified');

    }
    private static function handleResponse($success,$message) {
        echo json_encode(['success' => $success, 'message' => $message]);
        return;
    }
}