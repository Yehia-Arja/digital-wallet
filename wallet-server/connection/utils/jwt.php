<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use Firebase\JWT\JWT;


function generateJWT($userId,$email,$userType) {
    $secretKey = "your_secret_key"; 
    $issuedAt = time();
    $expirationTime = $issuedAt + (60 * 60 * 24);

    $payload = [
        'iat' => $issuedAt,
        'exp' => $expirationTime,
        'user_id' => $userId,
        'user_type' => $userType
    ];

    return JWT::encode($payload, $secretKey, 'HS256');
}
