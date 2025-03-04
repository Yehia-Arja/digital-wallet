<?php
require_once __DIR__ . "/../../../models/users.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $users = User::countUsers();

    echo json_encode(['success' => true, 'message' => $users]);
    return;
}