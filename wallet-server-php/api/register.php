<?php

require_once "../db/connection.php";

header('Access-Control-Allow-Origin: *'); // Allow requests from any origin
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Allow specific methods
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allow specific headers
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $verify_password = $_POST['verifyPassword'];

    if (empty($email) || empty($username) || empty($password) || empty($verify_password)) {
        echo json_encode(['status'=> 'error','message'=> 'Missing Information']);
        exit;
    }
    if ($password !== $verify_password) {
        echo json_encode(['status'=> 'error','message'=> 'Passwords Do Not Match']);
        exit;
    }
    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status'=> 'error','message'=> 'Email Already Exists']);
        exit;
    }
    $stmt->close();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare('INSERT INTO users(email,username,password) VALUES(?,?,?)');
    $stmt->bind_param('sss', $email,$username,$hashed_password);

    if ($stmt->execute()) {
        echo json_encode(['status'=> 'success','message'=> 'Registered Successfully']);
    }else {
        echo json_encode(['status'=> 'error','message'=> 'Registered Failed']);
    }
    $stmt->close();
    $conn->close();
}else {
    echo json_encode(['status'=> 'error','message'=> 'Invalid Request']);
}