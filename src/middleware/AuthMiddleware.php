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
            $currentPath = $_SERVER['REQUEST_URI'];
            
            if (strpos($currentPath, 'login') === false && strpos($currentPath, 'register') === false) {
                header('Location: /login');
                exit();
            }
        }
    }

    public static function redirectIfLoggedIn() {
        if (self::isLoggedIn()) {
            header('Location: /dashboard');
            exit();
        }
    }
}
