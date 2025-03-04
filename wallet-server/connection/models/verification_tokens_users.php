<?php
require_once __DIR__ . '/../connection.php';

class Verification_tokens_user
{
    public static function storeToken($data, $user_id)
    {
        global $conn;

        $token = $data['token'];
        $expiresAt = $data['expiresAt'];

        $sql = $conn->prepare("INSERT INTO verification_tokens (user_id,token,expires_at) VALUES (?,?,?)
        ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)");

        $sql->bind_param("iss", $user_id, $token, $expiresAt);

        if ($sql->execute()) {
            return $token;
        }
        return false;
    }
    public static function verifyToken($token)
    {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM verification_tokens WHERE token = ? AND expires_at > NOW()");
        $sql->bind_param("s", $token);
        $sql->execute();
        $result = $sql->get_result()->fetch_assoc();

        return $result ? $result['user_id'] : false;
    }
}