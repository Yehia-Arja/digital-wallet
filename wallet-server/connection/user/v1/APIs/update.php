<?php
require_once __DIR__ . "/../../../models/users.php";

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $address = $_POST['address'];


    if (empty($username) || empty($address)) {
        echo json_encode(['success' => false, 'message' => 'missing info']);
        return;
    }
    User::updateUser($user_id, $username, $address);
    echo json_encode(['success' => true, 'message' => 'user updated']);
    return;
}