<?php
require_once __DIR__ . '/../connection.php';

class Wallet {
    public static function createWallet($user_id, $balance = 0.00) {
        global $conn;

        $wallet_number = self::generateWalletNumber();
        $sql = $conn->prepare("INSERT INTO wallets (wallet_number,user_id, balance) VALUES (?,?,?)");
        $sql->bind_param("sid",$wallet_number, $user_id, $balance);
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

        $sql = "SELECT * FROM wallets WHERE wallet_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $wallet_number);
        $stmt->execute();
        $result = $stmt->get_result();
        $wallet = $result->fetch_assoc();
        
        return $wallet ? $wallet['wallet_id'] : null;
    }
    public static function getBalance($wallet_id) {
        global $conn;

        $sql = $conn->prepare("SELECT balance FROM wallets WHERE id = ?");
        $sql->bind_param("i", $wallet_id);
        $sql->execute();
        $result = $sql->get_result()->fetch_assoc();

        return $result['balance'];
    }
    public static function getWalletsByUserId($user_id) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM wallets WHERE user_id = ?");
        $sql->bind_param("i", $user_id);
        $sql->execute();
        $result = $sql->get_result()->fetch_all(MYSQLI_ASSOC);

        return $result;
    }
    public static function checkWalletNumber($wallet_number) {
        global $conn;

        $sql = $conn->prepare('SELECT * FROM wallets WHERE wallet_number = ?');
        $sql->bind_param('s', $wallet_number);
        $sql->execute();
        $result = $sql->get_result()->fetch_assoc();
        if (!$result) {
            return false;
        }
        return true;
    }
    public static function updateWalletBalance($wallet_id, $new_balance) {
        global $conn;

        $sql = $conn->prepare("UPDATE wallets SET balance = ? WHERE id = ?");
        $sql->bind_param("di", $new_balance, $wallet_id);
        return $sql->execute();
    }

    public static function deleteWallet($wallet_id) {
        global $conn;
        
        $sql = $conn->prepare("DELETE FROM wallets WHERE id = ?");
        $sql->bind_param("i", $wallet_id);
        return $sql->execute();
    }
  
    public static function generateWalletNumber($length = 8) {
        $wallet_number = self::generateRandomNumber($length);
        
      
        while (self::checkWalletNumber($wallet_number)) {
            $wallet_number = self::generateRandomNumber($length);
        }
        
        return $wallet_number; 
    }

   
    private static function generateRandomNumber($length = 8) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}

