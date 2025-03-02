<?php
require_once __DIR__ . "/../../../models/users.php";
require_once __DIR__ . "/../../../connection.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '') ?: null;
    $phone_number = trim($_POST['phone_number'] ?? '') ?: null;
    $password = trim($_POST['password'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $id_url = trim($_POST['id_url'] ?? '');

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $data = [
        'username' => $username,
        'email' => $email,
        'phone_number' => $phone_number,
        'hashed_password' => $hashed_password,
        'address' => $address,
        'id_url' => $id_url,
        'user_type_id'=>2
    ];

    if (empty($username) || empty($email) && empty($phone_number) || empty($password) || 
        empty($address) || empty($id_url)) {

        echo json_encode(['status' => 'failed', 'message' => 'missing information']);
        return;
    }

    if (Users::checkUser($data,$conn)) {        
        echo json_encode(['status' => 'failed', 'message' => 'user already exists']);
        return;
    }
    
    if (Users::signup($data,$conn)) {
        echo json_encode(['status' => 'success', 'message' => 'registered']);
        return;
    }
    echo json_encode(['status' => 'failed', 'message' => 'problem during registration']);
    return;
}