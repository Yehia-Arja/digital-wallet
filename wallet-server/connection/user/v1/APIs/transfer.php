<?php
require_once __DIR__ . '/../utils/auth.php';
require_once __DIR__ . '/../utils/email.php';
require_once __DIR__ . '/../modules/wallets.php';
require_once __DIR__ . '/../modules/transactions.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wallet_number = $input['wallet_number'] ?? '';
    $receiver_wallet_number = $input['receiver_wallet_number'] ?? '';
    $amount = $input['amount'] ?? '';
    
    
    if (!$amount || !$receiver_wallet_id || !$wallet_number) {
        echo json_encode(['success' => false, 'message' => 'missing information']);
        return;
    }

    $wallet_id = Wallet::getWalletIdByNumber($wallet_number);

    if (!$wallet_id) {
        echo json_encode(['success' => false, 'message' => 'invalid wallet_number']);
        return;
    }
    $balance = Wallet::getBalance($wallet_id);
    $new_balance = $balance - $amount;
    
    if ($amount>$balance) {
        echo json_encode(['success' => false, 'message' => 'insufficient funds']);
        return;
    }
    Wallet::updateWalletBalance($wallet_id, $new_balance);
    Transaction::createTransaction($user_id, $wallet_id, 'transfer', $amount);


    $receiver_wallet_id = Wallet::getWalletIdByNumber($receiver_wallet_number);
    
    if (!$receiver_wallet_id) {
        echo json_encode(['success' => false, 'message' => 'invalid receiver_wallet_number']);
        return;
    }
    $receiver_balance = Wallet::getBalance($receiver_wallet_id);
    $receiver_new_balance = $receiver_balance + $amount;

    Wallet::updateWalletBalance($receiver_wallet_id, $receiver_new_balance);


    echo json_encode(['success' => false, 'message' => 'transferred']);
}