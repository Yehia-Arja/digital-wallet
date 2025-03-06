<?php

require_once __DIR__ . '/../../../models/users.php';

header('Access-Control-Allow-Origin:*'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $user = User::getUserById($user_id);
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'Something went wrong user doesnt exist']);
        return;
    }

    $username = $user['username'];
    $address = $user['address'];
    

   

    return json_encode(['success ' => true, 'message' => [$username,$address]]);
    

}