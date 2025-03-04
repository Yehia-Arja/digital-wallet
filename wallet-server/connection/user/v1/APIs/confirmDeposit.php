<?php
require_once __DIR__ . '/../../../models/transactions.php';
require_once __DIR__ . '/../../../models/wallets.php';
require_once __DIR__ . '/../../../utils/email.php';

header('Content-Type: application/json');

class DepositConfirmHandler
{
    public static function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return self::sendResponse(false, 'Invalid request.');
        }

        $token = $_GET['token'] ?? '';
        if (!$token) {
            return self::sendResponse(false, 'Token is missing.');
        }

        $transaction_id = Verification_tokens_transaction::verifyToken($token);
        if (!$transaction_id) {
            return self::sendResponse(false, 'Invalid or expired token.');
        }

        $wallet_id = Verification_tokens_transaction::getWalletIdByTransactionId($transaction_id);
        $amount = Verification_tokens_transaction::getAmountByTransactionId($transaction_id);
        $balance = Wallet::getBalance($wallet_id);
        $new_balance = $balance + $amount;
        
        Wallet::updateWalletBalance($wallet_id, $new_balance);
        Transaction::updateTransactionStatus($transaction_id, 'completed');

        return self::sendResponse(true, 'Deposit confirmed successfully.');
    }

    private static function sendResponse($success, $message)
    {
        echo json_encode(['success' => $success, 'message' => $message]);
        exit;
    }
}


DepositConfirmHandler::handleRequest();
