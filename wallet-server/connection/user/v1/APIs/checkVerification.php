<?php
require_once __DIR__ . '/../../../models/users.php';

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    $user = User::getUserById($user_id);
    $is_verified = $user['is_verified'];
    if ($is_verified>0) {
        echo json_encode(['success'=>true,'message'=>$is_verified]);
    } else {
        echo json_encode(['success'=>false,'message'=>'user not found or not verified']);
    }
}
?>
