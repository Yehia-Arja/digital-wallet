<?php
require_once __DIR__ . '/../connection.php';

class Transactions {
    public static function createTransaction($user_id,$walletId, $type, $amount, $status = 'pending') {
        global $conn;

        $sql = $conn->prepare("INSERT INTO transactions (user_id,wallet_id, type, amount, status) VALUES (?,?, ?, ?, ?)");
        $sql->bind_param("iisds",$user_id, $walletId, $type, $amount, $status);
        return $sql->execute();
    }

    public static function getTransactionById($transactionId) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM transactions WHERE id = ?");
        $sql->bind_param("i", $transactionId);
        $sql->execute();
        return $sql->get_result()->fetch_assoc();
    }

    public static function getTransactionsByWalletId($walletId) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM transactions WHERE wallet_id = ? ORDER BY created_at DESC");
        $sql->bind_param("i", $walletId);
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function getAllUserTransactions($user_id) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC");
        $sql->bind_param("i", $user_id);
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public static function updateTransactionStatus($transactionId, $newStatus) {
        global $conn;

        $sql = $conn->prepare("UPDATE transactions SET status = ? WHERE id = ?");
        $sql->bind_param("si", $newStatus, $transactionId);
        return $sql->execute();
    }
}
