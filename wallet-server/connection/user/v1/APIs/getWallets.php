<?php

require_once __DIR__ . '/../../../models/wallets.php';

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $wallets = Wallet::getWalletsByUserId($user_id);
    if (!$wallets) {
        echo json_encode(['success' => false, 'message' => 'No wallets found.']);
        return;
    }

    echo json_encode(['success' => true, 'message' => $wallets]);
    return;

}