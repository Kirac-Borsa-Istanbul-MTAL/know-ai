<?php
session_start(); 
require_once __DIR__ . '/../models/register.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $name = $_POST['name'] ?? '';

    $registerModel = new RegisterModel();
    $result = $registerModel->createUser($email, $password, $name);

    if ($result['success']) {
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['email'] = $result['email'];
        $_SESSION['name'] = $result['name'];
        header('Location: ' . url('home'));
        exit();
    } else {
        $_SESSION['error'] = $result['error'];
        header('Location: ' . url('register'));
        exit();
    }
}
?>