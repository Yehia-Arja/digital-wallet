<?php
require_once __DIR__ . "/../../../models/users.php";
require_once __DIR__ . "/../../../models/transactions.php";

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $users = User::countUsers();
    $transactions = Transaction::countTransactions();

    echo json_encode(['success' => true, 'message' => [$users,$transactions]]);
    return;
}