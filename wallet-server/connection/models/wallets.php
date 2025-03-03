<?php
require_once __DIR__ . '/../connection.php';

class Wallets {
    public static function createWallet($userId, $balance = 0.00) {
        global $conn;

        $sql = $conn->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, ?)");
        $sql->bind_param("id", $userId, $balance);
        return $sql->execute();
    }

    public static function getWalletById($walletId) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM wallets WHERE id = ?");
        $sql->bind_param("i", $walletId);
        $sql->execute();
        return $sql->get_result()->fetch_assoc();
    }

    public static function getWalletsByUserId($userId) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM wallets WHERE user_id = ?");
        $sql->bind_param("i", $userId);
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function updateWalletBalance($walletId, $newBalance) {
        global $conn;

        $sql = $conn->prepare("UPDATE wallets SET balance = ? WHERE id = ?");
        $sql->bind_param("di", $newBalance, $walletId);
        return $sql->execute();
    }

    public static function deleteWallet($walletId) {
        global $conn;
        
        $sql = $conn->prepare("DELETE FROM wallets WHERE id = ?");
        $sql->bind_param("i", $walletId);
        return $sql->execute();
    }
}
