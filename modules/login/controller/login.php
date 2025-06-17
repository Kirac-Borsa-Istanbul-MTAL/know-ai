<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    var_dump($email, $password);
    if ($email === 'admin@mail.com' && $password === 'password') {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = $username;
        header('Location: ' . url('dashboard'));
        exit();
    } else {
        $_SESSION['error'] = 'Invalid username or password';
        header('Location: ' . url('login'));
        exit();
    }
}
?>
