<?php
require_once __DIR__ . '/../utils/auth.php';
require_once __DIR__ . '/../utils/email.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $input['username'];
    $address = $input['address'];
    $password = $input['password'];

    if (empty($username) || empty($address) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'missing info']);
        return;
    }
    User::updateUser($user_id, $username, $address, $password);
    echo json_encode(['success' => true, 'message' => 'user updated']);
    return;
}