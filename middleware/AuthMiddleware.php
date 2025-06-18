<?php

class AuthMiddleware {
    public static function isLoggedIn() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }

    public static function requireAuth() {
        if (!self::isLoggedIn()) {
            header('Location: ' . url('login'));
            exit();
        }
    }

    public static function redirectIfLoggedIn() {
        if (self::isLoggedIn()) {
            header('Location: ' . url('home'));
            exit();
        }
    }
}
?>