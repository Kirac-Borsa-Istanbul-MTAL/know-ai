<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    var_dump($username, $password);
    if ($username === 'admin@mail.com' && $password === 'password') {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = $username;
        header('Location: /dashboard');
        exit();
    } else {
        $_SESSION['error'] = 'Invalid username or password';
        header('Location: /login');
        exit();
    }
}
?>
