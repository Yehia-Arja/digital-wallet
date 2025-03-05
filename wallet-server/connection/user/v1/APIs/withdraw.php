<?php

require_once __DIR__ . '/../../../models/wallets.php';
require_once __DIR__ . '/../../../models/transactions.php';

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $wallet_id = $_POST['wallet_id'] ?? '';
    $amount = $_POST['amount'] ?? 0;



    if (!$wallet_id) {
        echo json_encode(['success' => false, 'message' => 'invalid wallet_number']);
        return;
    }
    $balance = Wallet::getBalance($wallet_id);

    if ($amount > $balance) {
        echo json_encode(['success' => false, 'message' => 'insufficient funds']);
        return;
    }
    $new_balance = $balance - $amount;
    $transaction_id = Transaction::createTransaction($user_id, $wallet_id, 'deposit', $amount);
    Wallet::updateWalletBalance($wallet_id,$new_balance);
    
    echo json_encode(['success' => true, 'message' => 'withdrawed']);
    return;
}