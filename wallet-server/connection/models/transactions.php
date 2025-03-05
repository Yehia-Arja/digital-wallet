<?php
require_once __DIR__ . '/../connection.php';

class Transaction {
    public static function createTransaction($user_id,$wallet_id, $type, $amount) {
        global $conn;

        $sql = $conn->prepare("INSERT INTO transactions (user_id,wallet_id, type, amount) VALUES (?, ?, ?, ?)");
        $sql->bind_param("iisd",$user_id, $wallet_id, $type, $amount);
        if ($sql->execute()) {
            return $sql->insert_id;
        }
        return false;
    }

    public static function getTransactionById($transactionId) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM transactions WHERE id = ?");
        $sql->bind_param("i", $transactionId);
        $sql->execute();
        return $sql->get_result()->fetch_assoc();
    }

    public static function getTransactionsByWalletId($wallet_id) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM transactions WHERE wallet_id = ? ORDER BY created_at DESC");
        $sql->bind_param("i", $wallet_id);
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
    
}
