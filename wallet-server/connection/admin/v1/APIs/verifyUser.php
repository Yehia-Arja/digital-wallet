<?php
require_once __DIR__ . "/../../../models/users.php";
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $input['email'];
    $user_id = User::getUserByEmail($email);
    User::verifyUsers($user_id);

    echo json_encode(['success' => true, 'message' => 'user verified']);
    return;
}