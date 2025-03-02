<?php
require_once __DIR__ . "/../../../models/users.php";
require_once __DIR__ . "/../../../connection.php";



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $password = $_POST['password'] ?? '';

    $data = ['email'=>$email,'phone_number'=>$phone_number,'password'=>$password];

    if (empty($email) && empty($phone_number)) {
        echo json_encode(['status' => 'failed', 'message' => 'missing information']);
        return;
    }
    if (Users::checkUser($data, $conn)) {

        if (Users::checkPasswords($data, $conn)) {
            echo json_encode(['status' => 'success', 'message' => 'logged in']);
            return;
        }else {
            echo json_encode(['status' => 'failed', 'message' => 'password incorrect']);
            return;
        }

    }else {
        echo json_encode(['status' => 'failed', 'message' =>'user does not exist']);
            return;
    }

}else {
    echo json_encode(['status' => 'failed', 'message' => 'unkown request']);
    return;
}