<?php

require_once __DIR__ . '/../../../models/users.php';

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$upload_dir = __DIR__ . "/../uploads/"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $phone_number = $_POST['phoneNumber'] ?? ''; 
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirmPassword'] ?? '';
    $username = $_POST['username'] ?? '';
    $address = $_POST['address'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
        return;
    }

    if (!isset($_FILES["file"])) {
        echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
        return;
    }

    $file_name = time() . "_" . basename($_FILES["file"]["name"]);
    $file_path = $upload_dir . $file_name;
    $file_url = "http://localhost/digital-wallet/wallet-server/connection/uploads/" . $file_name; 

    if (User::getUserByEmail($email)) {
        echo json_encode(['success' => false, 'message' => 'Email already registered.']);
        return;
    }

    if (empty($email) || empty($phone_number) || empty($password) || empty($confirm_password) || empty($username) || empty($address)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        return;
    }

    if ($password !== $confirm_password) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        return;
    }

    if (!move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
        return;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    if (!User::createUser($email, $phone_number, $hashed_password, $username,$address ,$file_url)) {
        echo json_encode(['success' => false, 'message' => 'Failed to create account.']);
        return;
    }

    $new_user = User::getUserByEmail($email);
    if ($new_user && isset($new_user['user_id'])) {
        echo json_encode(['success' => true, 'message' => $new_user['user_id']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching user after creation.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
