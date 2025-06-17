<?php
if (preg_match('/\.(?:css|js|jpg|jpeg|png|gif)$/', $_SERVER["REQUEST_URI"])) {
    $filePath = __DIR__ . $_SERVER["REQUEST_URI"];
    if (file_exists($filePath)) {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $contentTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif'
        ];

        if (isset($contentTypes[$extension])) {
            header('Content-Type: ' . $contentTypes[$extension]);
            readfile($filePath);
            exit;
        }
    }
}

require_once __DIR__ . '/middleware/AuthMiddleware.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);

$publicRoutes = [
    '/login',
    '/register',
    '/assets/',
    '/css/',
    '/js/'
];

$isPublicRoute = false;
foreach ($publicRoutes as $route) {
    if (strpos($path, $route) === 0) {
        $isPublicRoute = true;
        break;
    }
}

if (!$isPublicRoute) {
    AuthMiddleware::requireAuth();
}

switch ($path) {
    case '/':
        if (AuthMiddleware::isLoggedIn()) {
            require __DIR__ . '/modules/main/views/dashboard.php';
        } else {
            header('Location: /login');
            exit();
        }
        break;

    case '/login':
        AuthMiddleware::redirectIfLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require __DIR__ . '/modules/login/controller/login_controller.php';
        } else {
            require __DIR__ . '/modules/login/views/login.php';
        }
        break;

    case '/register':
        AuthMiddleware::redirectIfLoggedIn();
        require __DIR__ . '/modules/login/views/register.php';
        break;

    case '/dashboard':
        require __DIR__ . '/modules/main/views/dashboard.php';
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/modules/404/404.php';
        break;
}
