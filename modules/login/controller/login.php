<?php
session_start();
require_once __DIR__ . '/../models/login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password_from_form = $_POST['password'] ?? '';

    $loginModel = new LoginModel();
    $user = $loginModel->getUserByEmail($email);

    if ($user && $loginModel->validatePassword($password_from_form, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['name'] = $user['name'];

        header('Location: ' . url('dashboard'));
        exit();
    } else {
        $_SESSION['error'] = 'Invalid email or password';
        header('Location: ' . url('login'));
        exit();
    }
}
