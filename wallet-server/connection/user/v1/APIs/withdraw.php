<?php
require_once __DIR__ . '/../utils/auth.php';
require_once __DIR__ . '/../utils/email.php';
require_once __DIR__ . '/../modules/wallets.php';
require_once __DIR__ . '/../modules/transactions.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $input['user_id'] ?? '';
    $wallet_number = $input['wallet_id'] ?? '';
    $amount = $input['amount'] ?? 0;
    $email = $input['email'] ?? '';


    
    $wallet_id = Wallet::getWalletIdByNumber($wallet_number);
    if (!$wallet_id) {
        echo json_encode(['success' => false, 'message' => 'invalid wallet_number']);
        return;
    }
    $balance = Wallet::getBalance($wallet_id);

    if ($amount > $balance) {
        echo json_encode(['success' => false, 'message' => 'insufficient funds']);
        return;
    }
    $transaction_id = Transaction::createTransaction($user_id, $wallet_id, 'deposit', $amount);


    $data = generateVerificationToken();
    $token = $data['token'];
    Verification_tokens_transaction::storeToken($data, $transaction_id, $wallet_id, $amount);
    sendDepositEmail($email, $token);
    
    echo json_encode(['success' => true, 'message' => 'withdraw request sent. please confirm via email.']);
    return;
}