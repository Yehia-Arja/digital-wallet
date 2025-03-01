<?php
require_once '../connection.php';

class Wallets{
    private static function checkError($sql) {
        if (!$sql) {
            echo "SQL preperation error: ";
            return false;
        }
        if (!$sql->execute()) {
            echo "SQL execution error";
            return false;
        }
        return true;
    }
    
     public static function getUserWallets($user_id,$conn) {

        $sql = $conn->prepare('SELECT wallet_number,balance FROM wallets WHERE user_id = ?');
        $sql->bind_param('i', $user_id);

        if (!self::checkError($sql)) {
            return false;
        }

        $result = $sql->get_result();
        $wallets = [];

        while($row = $result->fetch_assoc()) {
            $wallets = [
                'wallet_number' => $row['wallet_number'],
                'balance' => $row['balance']
            ];
        }

        return $wallets;
       
    }
    public static function getBalance($wallet_id,$conn) {

        $sql = $conn->prepare('SELECT balance FROM wallets WHERE wallet_id = ?');
        $sql->bind_param('i', $wallet_id);
        
        if (!self::checkError($sql)) {
            return false;
        }
        $result = $sql->get_result()->fetch_assoc();
        $balance = $result['balance'];
        return $balance;
    }  
    public static function createWallet($data,$conn){

        $wallet_id = $data['wallet_id'];
        $wallet_number = $data['wallet_number'];
        $user_id = $data['user_id'];

        $sql = $conn->prepare('INSERT INTO wallets ($wallet_id, $wallet_number,$user_id) VALUES (?,?,?)');
        $sql->bind_param('isi', $wallet_id, $wallet_number,$user_id);
        
        if (!self::checkError($sql)) {
            return false;
        }
        return true;

    }

    public static function deposit($wallet_id,$amount,$conn) {

        $sql = $conn->prepare('UPDATE wallets SET balance = balance + ? WHERE wallet_id = ?');
        $sql->bind_param('di', $amount, $wallet_id);
       
        if (!self::checkError($sql)) {
            return false;
        }
        return true;
    }

    public static function withdraw($wallet_id,$amount,$conn) {
        
        $sql = $conn->prepare('UPDATE wallets SET balance = balance - ? WHERE wallet_id = ?');
        $sql->bind_param('di', $amount, $wallet_id);
       
        if (!self::checkError($sql)) {
            return false;
        }


        $sql = $conn->prepare('UPDATE cards SET balance = balance + ? WHERE wallet_id = ?');
        $sql->bind_param('di', $amount, $wallet_id);
        
        if (!self::checkError($sql)) {
            return false;
        }
        return true;
    }
     
    public static function transfer($data,$conn) {

        $sender_wallet_id = $data['sender_wallet_id'];
        $recieving_wallet_id = $data['recieving_wallet_id'];
        $amount = $data['amount'];

        $sql = $conn->prepare('UPDATE wallets SET balance = balance + ? WHERE wallet_id = ?');
        $sql->bind_param('di', $amount,$recieving_wallet_id);
       
        if (!self::checkError($sql)) {
            return false;
        }
        
        $sql = $conn->prepare('UPDATE wallets SET balance = balance - ? WHERE wallet_id = ?');
        $sql->bind_param('di', $amount, $sender_wallet_id);
        
        if (!self::checkError($sql)) {
            return false;
        }
        return true;
    }
    public static function deleteWallet($wallet_id,$conn) {

        $sql = $conn->prepare('DELETE FROM wallets WHERE wallet_id = ?');
        $sql->bind_param('i', $wallet_id);
        
        if (!self::checkError($sql)) {
            return false;
        }
        return true;
    }
}

