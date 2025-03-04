<?php
require_once __DIR__ . '/../connection.php';

class User {
    public static function createUser($email, $phone, $passwordHash, $fullName, $userTypeId = 2) {
        global $conn;

        $sql = $conn->prepare("INSERT INTO users (email, phone, password_hash, full_name, user_type_id) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param("ssssi", $email, $phone, $passwordHash, $fullName, $userTypeId);
        return $sql->execute();
    }

    public static function getUserByEmail($email) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        return $sql->get_result()->fetch_assoc();
    }
    public static function authenticate($email,$password) {
        global $conn;

        $sql = $conn->prepare("SELECT password FROM users WHERE email = ?");
        $sql->bind_param('s', $email);
        $result = $sql->get_result()->fetch_assoc();
        $hashed_password_db = $result['password'];

        if (password_verify($password,$hashed_password_db)) {
            return $result;
        }
        return false;

    }
    public static function acceptUsers($user_id) {
        global $conn;

        $sql = $conn->prepare("UPDATE users SET is_accepted = true WHERE user_id = ? ");
        $sql->bind_param('i', $user_id);
        return $sql->execute();
    }
    
    public static function getPendingUsers() {
        global $conn;

        $sql = $conn->prepare("SELECT user_id, full_name, email, phone FROM users WHERE is_verified != true");
        $sql->execute();
        $result = $sql->get_result();
        return $result;
    }
    public static function verifyUsers($user_id) {
        global $conn;

        $sql = $conn->prepare('UPDATE users SET is_verified = true WHERE user_id = ?');
        $sql->bind_param('i',$user_id);
        return $sql->execute();
    }
    public static function countUsers() {
        global $conn;

        $sql = $conn->prepare("SELECT COUNT(*) AS user_count FROM users");
        $result = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    public static function getUserById($user_id) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $sql->bind_param("i", $user_id);
        $sql->execute();
        return $sql->get_result()->fetch_assoc();
    }

    public static function updateUser($user_id, $username, $address,$password) {
        global $conn;

        $sql = $conn->prepare("UPDATE users SET username = ?, address = ?, password = ? WHERE user_id = ?");
        $sql->bind_param("ssi", $username, $address, $user_id);
        return $sql->execute();
    }

    public static function updatePassword($user_id,$new_password) {
        global $conn;

        $sql = $conn->prepare("UPDATE users SET password = ?, address = ? WHERE user_id = ?");
        $sql->bind_param("si", $new_password, $user_id);
        return $sql->execute();
    }
    public static function deleteUser($user_id) {
        global $conn;

        $sql = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $sql->bind_param("i", $user_id);
        return $sql->execute();
    }
}
