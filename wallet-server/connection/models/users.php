<?php
require_once __DIR__ . '/../connection.php';


class Users{
    private static function checkError($sql) {
        if (!$sql) {
            echo "SQL preperation error";
            return false;
            
        }
        if (!$sql->execute()) {
            echo "SQL execution error";     
            return false;
        }
        return true;
    }
    
     public static function getUserId($key,$conn) {

        $sql = $conn->prepare('SELECT user_id FROM users WHERE email = ?, phone_number = ?');
        $sql->bind_param('ss',$key,$key);

        if (!self::checkError($sql)) {
            return false;
        }

        $result = $sql->get_result()->fetch_assoc();
        
        if ($result && isset($result['user_id'])) {
            return $result['user_id'];
        }
        return false;
    }  
     public static function getUsers($conn) {

        $sql = $conn->prepare('SELECT COUNT(*) AS total_users FROM users');

        if (!self::checkError($sql)) {
            return false;
        }

        $result = $sql->get_result()->fetch_assoc();
        $users = $result['total_users'];


        return $users;
       
    }
    public static function signup($data,$conn) {

        $username = $data['username'];
        $email = $data['email'];
        $phone_number = $data['phone_number'];
        $hashed_password = $data['hashed_password'];
        $address = $data['address'];
        $id_url = $data['id_url'];
        $user_type_id = $data['user_type_id'];

        $sql = $conn->prepare('INSERT INTO users (username,email,phone_number,password,address,id_document,user_type_id)
        VALUES (?,?,?,?,?,?,?)');
        $sql->bind_param('ssssssi', $username, $email,$phone_number, $hashed_password, $address, $id_url,$user_type_id);
        
        if (!self::checkError($sql)) {
            return false;
        }
        return true;
    }  
    public static function checkUser($data,$conn){
        $email = $data['email'];
        $phone_number = $data['phone_number'];

        $sql = $conn->prepare('SELECT user_id FROM users WHERE email = ? OR phone_number = ?');
        $sql->bind_param('ss', $email, $phone_number);
        
        if (!self::checkError($sql)) {
            return false;
        }

        $result = $sql->get_result();
        if ($result->num_rows>0) {
            return true;
        }
        return false;
    }

    public static function checkPasswords($data,$conn) {

        $email = $data['email'];
        $phone_number = $data['phone_number'];
        $password = $data['password'];

        $sql = $conn->prepare('SELECT password FROM users WHERE email = ? OR phone_number = ?');
        $sql->bind_param('ss', $email, $phone_number);
       
        if (!self::checkError($sql)) {
            return false;
        }
        $result = $sql->get_result()->fetch_assoc();
        $hashed_password = $result['password'];
        return password_verify($password, $hashed_password) ? true : false;
    }
    public static function storeToken($data,$conn) {

        $hashed_token = $data['hashed_token'];
        $token_expires_at = $data['token_expires_at'];
        $email = $data['email'];
        $phone_number = $data['phone_number'];

        $sql = $conn->prepare('UPDATE users SET token = ? AND token_expires_at = ?
        WHERE email = ? OR phone_number = ?');
        $sql->bind_param('ssss', $hashed_token,$token_expires_at,$email,$phone_number);

        if (self::checkError($sql)) {
            return false;
        }
        return true;
    }

    public static function confirmToken ($user_id,$token,$conn) {

        $sql = $conn->prepare('SELECT token,token_expires_at FROM users WHERE user_id = ?');
        $sql->bind_param('s',$user_id);
        
        if(self::checkError($sql)) {
            return false;
        }

        $result = $sql->get_result()->fetch_assoc();
        $token_from_db = $result['token'];

        if (password_verify($token,$token_from_db) && $result['token_expires_at']>time()) {
            return true;
        }
        return false;

    }
    public static function resetPassword($data,$conn) {
        $new_password = $data['new_password'];
        $user_id = $data['user_id'];
        
        $sql = $conn->prepare('UPDATE users SET password = ? WHERE user_id = ?');
        $sql->bind_param('si', $new_password, $user_id);
       
        if (!self::checkError($sql)) {
            return false;
        }
        return true;
    }
     
    public static function updateProfile($data,$conn) {

        $username = $data['username'];
        $password = $data['password'];
        $address = $data['address'];

        $sql = $conn->prepare('UPDATE users SET username = ? AND password = ? AND address = ?');
        $sql->bind_param('sss', $username,$password,$address);
       
        if (!self::checkError($sql)) {
            return false;
        }
        return true;
    }
}

