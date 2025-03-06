<?php

require_once __DIR__ . '/../../../models/wallets.php';
require_once __DIR__ . '/../../../models/transactions.php';





if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $wallet_id = $_POST['wallet_id'] ?? '';
    $amount = $_POST['amount'] ?? 0;
    


    if ($amount <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid amount.']);
        return;
    }

    if (!$wallet_id) {
        echo json_encode(['success' => false, 'message' => 'invalid wallet number']);
        return;
    }
    $balance = Wallet::getBalance($wallet_id);
    $transaction_id = Transaction::createTransaction($user_id, $wallet_id, 'deposit', $amount);
    $new_balance = $balance + $amount;

    Wallet::updateWalletBalance($wallet_id, $new_balance);
    
    echo json_encode(['success' => true, 'message' => 'Depositted.']);
    return;
}