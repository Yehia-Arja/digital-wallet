<?php

require_once __DIR__ . '/../../../models/users.php';

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
        return;
    }
    $user = User::authenticate($email,$password);

    if ($user) {
        echo json_encode(['success' => true, 'message' => $user['user_id']]);
        return;
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials.']);
        return;
    }
    
}else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    return;
}

