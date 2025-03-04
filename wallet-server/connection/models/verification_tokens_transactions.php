
 
<?php
require_once __DIR__ . '/../connection.php';

class Verification_tokens_transaction
{
    public static function storeToken($data,$transaction_id,$wallet_id,$amount)
    {
        global $conn;

        $token = $data['token'];
        $expiresAt = $data['expiresAt'];

        $sql = $conn->prepare("INSERT INTO verification_tokens_transactions 
        (transaction_id,wallet_id,amount,token,expires_at) VALUES (?,?,?,?,?)
        ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)");

        $sql->bind_param("iss", $transaction_id, $wallet_id,$amount,$token, $expiresAt);

        if ($sql->execute()) {
            return $token;
        }
        return false;
    }
    public static function verifyToken($token)
    {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM verification_tokens_transactions WHERE token = ? AND expires_at > NOW()");
        $sql->bind_param("s", $token);
        $sql->execute();
        $result = $sql->get_result()->fetch_assoc();

        return $result ? $result['transaction_id'] : false;
    }
    public static function getWalletIdByTransactionId($transaction_id) 
    {
        global $conn;

        $sql = $conn->prepare("SELECT wallet_id FROM verification_tokens WHERE transaction_id = ?");
        $sql->bind_param("i", $transaction_id);
        $sql->execute();
        return $result = $sql->get_result()->fetch_assoc();
    }
    public static function getAmountByTransactionId($transaction_id) 
    {
        global $conn;

        $sql = $conn->prepare("SELECT amount FROM verification_tokens WHERE transaction_id = ?");
        $sql->bind_param("i", $transaction_id);
        $sql->execute();
        return $result = $sql->get_result()->fetch_assoc();
    }
}
 