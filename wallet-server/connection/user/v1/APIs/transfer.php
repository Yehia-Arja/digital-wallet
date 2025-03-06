<?php
require_once __DIR__ . '/../../../models/wallets.php';
require_once __DIR__ . '/../../../models/transactions.php';


header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $sender_wallet_id = $_POST['sender_wallet_id'] ?? '';
    $receiver_wallet_number = $_POST['receiver_wallet_number'] ?? '';
    $amount = $_POST['amount'] ?? '';
    
    
    if (empty($amount) || empty($receiver_wallet_number) || empty($sender_wallet_id)) {
        echo json_encode(['success' => false, 'message' => 'missing information']);
        return;
    }


    if (!$sender_wallet_id) {
        echo json_encode(['success' => false, 'message' => 'invalid wallet number']);
        return;
    }

    if (!Wallet::checkWalletNumber($receiver_wallet_number)) {
        echo json_encode(['success' => false, 'message' => 'invalid wallet number']);
        return;
    }

    $balance = Wallet::getBalance($sender_wallet_id);

    if ($amount>$balance) {
        echo json_encode(['success' => false, 'message' => 'insufficient funds']);
        return;
    }

    $new_balance = $balance - $amount;
    
    Wallet::updateWalletBalance($sender_wallet_id, $new_balance);

    $receiver_wallet_id = Wallet::getWalletIdByNumber($receiver_wallet_number);
    
    if (!$receiver_wallet_id) {
        echo json_encode(['success' => false, 'message' => 'invalid receiver wallet_number']);
        return;
    }
    $receiver_balance = Wallet::getBalance($receiver_wallet_id);
    $receiver_new_balance = $receiver_balance + $amount;

    Wallet::updateWalletBalance($receiver_wallet_id, $receiver_new_balance);

    
    Transaction::createTransaction($user_id,$sender_wallet_id,'transfer', $amount);


    echo json_encode(['success' => true, 'message' => 'transferred']);
}