<?php
require_once __DIR__ . '/../connection.php';

class Wallet {
    public static function createWallet($userId, $balance = 0.00) {
        global $conn;

        $sql = $conn->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, ?)");
        $sql->bind_param("id", $userId, $balance);
        return $sql->execute();
    }

    public static function getWalletById($wallet_id) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM wallets WHERE id = ?");
        $sql->bind_param("i", $wallet_id);
        $sql->execute();
        $result = $sql->get_result()->fetch_assoc();

        return $result;
    }

    public static function getWalletIdByNumber($wallet_number) {
        global $conn;

        $sql = "SELECT wallet_id FROM wallets WHERE wallet_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $wallet_number);
        $stmt->execute();
        $result = $stmt->get_result();
        $wallet = $result->fetch_assoc();
        
        return $wallet ? $wallet['wallet_id'] : null;
    }
    public static function getBalance($wallet_id) {
        global $conn;

        $sql = $conn->prepare("SELECT balance FROM wallets WHERE wallet_id = ?");
        $sql->bind_param("i", $wallet_id);
        $sql->execute();
        $result = $sql->get_result()->fetch_assoc();

        return $result;
    }
    public static function getWalletsByUserId($userId) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM wallets WHERE user_id = ?");
        $sql->bind_param("i", $userId);
        $sql->execute();
        $result = $sql->get_result()->fetch_all(MYSQLI_ASSOC);

        return $result;
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
