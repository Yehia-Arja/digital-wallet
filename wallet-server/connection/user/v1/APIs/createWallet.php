<?php
require_once __DIR__ . '/../../../models/wallets.php';

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    if (!$user_id) {
        echo json_encode(['success' => false, 'message' => 'user not found']);
        return;
    }
    $wallet_id = Wallet::createWallet($user_id);
    if (!$wallet_id) {
        echo json_encode(['success' => false, 'message' => 'error try again later']);
        return;
    }
    echo json_encode(['success' => true, 'message' => 'Wallet created']);
    return;

}