<?php
require_once __DIR__ . '/../connection.php';

class Users {
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

    public static function getUserById($user_id) {
        global $conn;
        $sql = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $sql->bind_param("i", $user_id);
        $sql->execute();
        return $sql->get_result()->fetch_assoc();
    }

    public static function updateUser($user_idid, $fullName, $address) {
        global $conn;
        $sql = $conn->prepare("UPDATE users SET full_name = ?, address = ? WHERE user_id = ?");
        $sql->bind_param("ssi", $fullName, $address, $id);
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
