<?php
require_once __DIR__ . '/../../../utils/jwt.php';
require_once __DIR__ . '/../../../utils/email.php';
require_once __DIR__ . '/../../../models/users.php';
require_once __DIR__ . '/../../../models/verification_tokens_users.php';

header('Access-Control-Allow-Origin: *'); // Allow requests from any origin
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Allow specific methods
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allow specific headers
header('Content-Type: application/json');




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phoneNumber'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirmPassword'] ?? '';
    $username = $_POST['username'] ?? '';
    $fileUrl = $_POST['fileUrl'] ?? '';
    
    $user = User::getUserByEmail($email);
    if ($user) {
        echo json_encode(['success' => false, 'message' => 'Email already registered.']);
        return;
    }
    if (empty($email) || empty($phone) || empty($password) || empty($confirm_password) || empty($username) || empty($fileUrl)) {
        echo json_encode(['success' => false, 'message' =>$phone,$confirm_password,$password,$username,$fileUrl]);
        return;
    }
    if ($password !== $confirm_password) {
        echo json_encode(['success' => false, 'message' => 'passwords do not match']);
        return;
    }
    $target_dir = "../uploads/";
    $file_url = null;

    if (!empty($_FILES["profile_image"]["name"])) {
        $file_name = time() . "_" . basename($_FILES["profile_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFilePath)) {
            $fileUrl = "uploads/" . $fileName;
        } else {
            $response["message"] = "File upload failed.";
            echo json_encode($response);
        }
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    User::createUser($email, $phone, $hashed_password, $full_name);
    $result = User::getUserByEmail($email);
    $user_id = $result['user_id'];

    if ($user_id) {
        
        $data = generateVerificationToken();
        Verification_tokens_user::storeToken($data, $user_id);
        sendVerificationEmail($email, $token);
        echo json_encode(['success' => true, 'message' => 'Account created. Please verify your email.']);

    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create account.']);
        return;
    }
    
}

echo json_encode(['success' => false, 'message' => 'Invalid request.']);
return;
