<?php
require_once __DIR__ . '/../../../utils/jwt.php';
require_once __DIR__ . '/../../../modules/users.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';
    
    $user = User::authenticate($email, $password);
    if ($user) {
        $jwt = generateJWT($user['id'], $email,$user['user_type_id']);
        echo json_encode(['success' => true, 'token' => $jwt, 'user' => $user]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials.']);
    }
    return;
}

echo json_encode(['success' => false, 'message' => 'Invalid request.']);
return;
