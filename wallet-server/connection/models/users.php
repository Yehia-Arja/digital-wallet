<?php
require_once __DIR__ . '/../connection.php';

class User {
    public static function createUser($email, $phone, $password_hash, $username,$address,$file_url, $user_type_id=2) {
        global $conn;

        $sql = $conn->prepare("INSERT INTO users (email,phone_number,password,username,address,id_url,user_type_id) VALUES (?,?,?,?,?,?,?)");
        $sql->bind_param("ssssssi", $email, $phone, $password_hash, $username,$address,$file_url, $user_type_id);
        $sql->execute();
        return $user_id = mysqli_insert_id($conn);
    }

    public static function getUserByEmail($email) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result()->fetch_assoc();
        return $result;
    }
    public static function checkAdmin($user_id) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $sql->bind_param("s", $user_id);
        $sql->execute();
        $result = $sql->get_result()->fetch_assoc();
        return $result;
    }
    
    public static function authenticate($email,$password) {
        global $conn;

        $sql = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $sql->bind_param('s', $email);
        $sql->execute();
        $result = $sql->get_result()->fetch_assoc();
        $hashed_password_db = $result['password'];

        if (password_verify($password,$hashed_password_db)) {
            return $result;
        }
        return false;

    }
    
    public static function getPendingUsers() {
        global $conn;

        $sql = $conn->prepare("SELECT user_id, username, email, phone FROM users WHERE is_verified != true");
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
        $sql->execute();
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
    
    public static function updateUser($user_id, $username, $address) {
        global $conn;

        $sql = $conn->prepare("UPDATE users SET username = ?, address = ? WHERE user_id = ?");
        $sql->bind_param("ssi", $username, $address, $user_id);
        return $sql->execute();
    }

  
    public static function deleteUser($user_id) {
        global $conn;

        $sql = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $sql->bind_param("i", $user_id);
        return $sql->execute();
    }
}
