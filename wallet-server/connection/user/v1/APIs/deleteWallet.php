<?php
require_once __DIR__ . '/../../../models/wallets.php';

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wallet_id = $_POST['wallet_id'];
    if (!$wallet_id) {
        echo json_encode(['success' => false, 'message' => 'wallet not found']);
        return;
    }
   
    if (!Wallet::deleteWallet($wallet_id)) {
        echo json_encode(['success' => false, 'message' => 'error try again later']);
        return;
    }
    Wallet::deleteWallet($wallet_id);
    echo json_encode(['success' => true, 'message' => 'Wallet deleted']);
    return;

}