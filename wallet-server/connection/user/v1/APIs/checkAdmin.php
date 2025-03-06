<?php
require_once __DIR__ . '/../../../models/users.php';

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $user = User::checkAdmin($user_id);

    if ($user['user_type_id'] === 1) {
        echo json_encode(['success' => true, 'message' => $user['user_id']]);
        return;
    }
    echo json_encode(['success' => false, 'message' => 'not an admin']);
    return;
}
?>
