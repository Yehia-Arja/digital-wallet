<?php
require_once __DIR__ . "/../../../models/users.php";
header('Content-Type: application/json');



if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $pendingUsers = User::getPendingUsers();

    $users = [];
        while ($row = $pendingUsers->fetch_assoc()) {
            $users[] = $row;
        }
    echo json_encode(['success' => false, 'message' => $users]);
    return;
}
