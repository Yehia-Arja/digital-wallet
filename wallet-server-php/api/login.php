<?php

require_once "../db/connection.php";

header('Access-Control-Allow-Origin: *'); // Allow requests from any origin
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Allow specific methods
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allow specific headers
header('Content-Type: application/json');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo json_encode(['status'=> 'error','message'=> 'Missing Information']);
        exit;
    }
    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        if (password_verify($password, $hashed_password)) {
            echo json_encode(['status'=> 'success','message'=> 'Log in Successfully']);
        }else {
            echo json_encode(['status'=> 'error','message'=> 'Password Is Not Correct']);
        }
    }else {
        echo json_encode(['status'=> 'error','message'=> 'Email Does Not Exist']);
    }
    $stmt->close();
    $conn->close();

}else {
    echo json_encode(['status'=> 'error','message'=> 'Invalid Request']);
}