<?php
require_once __DIR__ . "/../../../models/users.php";

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $pendingUsers = User::getPendingUsers();

    $users = [];
        while ($row = $pendingUsers->fetch_assoc()) {
            $users[] = $row;
        }
    echo json_encode(['success' => false, 'message' => $users]);
    return;
}
