<?php
require_once __DIR__ . "/../../../models/users.php";

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    User::verifyUsers($user_id);

    echo json_encode(['success' => true, 'message' => 'user verified']);
    return;
}