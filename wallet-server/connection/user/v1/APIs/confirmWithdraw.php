<?php
require_once __DIR__ . "/../../../models/verification_tokens_transactions.php";
require_once __DIR__ . "/../../../models/wallets.php";
require_once __DIR__ . "/../../../models/transactions.php";

class ConfirmWithdrawHandler {
    public static function handleResponse() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return self::sendResponse(false, 'invalid request');
        }

        $token = $_GET['token'];

        if (!$token) {
            return self::sendResponse(false, 'missing token');
        }
        $transaction_id = Verification_tokens_transaction::verifyToken($token);
        $wallet_id = Verification_tokens_transaction::getWalletIdByTransactionId($transaction_id);
        $amount = Verification_tokens_transaction::getAmountByTransactionId($transaction_id);
    
        $balance = Wallet::getBalance($wallet_id);

        if ($amount>$balance) {
            return self::sendResponse(false, 'insufficient funds');
        }
        $new_balance = $balance - $amount;

        Wallet::updateWalletBalance($wallet_id, $new_balance);
        Transaction::updateTransactionStatus($transaction_id, 'completed');
        self::sendResponse(true, 'withdrawed');
    }
    private static function sendResponse($success,$message) {
        echo json_encode(['success' => $success, 'message' => $message]);
        return;
    }
}

