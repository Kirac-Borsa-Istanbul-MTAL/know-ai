<?php
require_once __DIR__ . '/config/mysql.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';
require_once __DIR__ . '/utils/url-formatter.php';
require_once __DIR__ . '/utils/localization.php';

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



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base_path = get_base_path();
$request_uri = $_SERVER['REQUEST_URI'];
$request_path = parse_url($request_uri, PHP_URL_PATH);

$path = '/';
if (strlen($base_path) > 0 && strpos($request_path, $base_path) === 0) {
    $path = substr($request_path, strlen($base_path));
} else {
    $path = $request_path;
}

if (empty($path)) {
    $path = '/';
}

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
            require __DIR__ . '/modules/home/views/home.php';
        } else {
            header('Location: ' . url('login'));
            exit();
        }
        break;

    case '/login':
        AuthMiddleware::redirectIfLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require __DIR__ . '/modules/login/controllers/login.php';
        } else {
            require __DIR__ . '/modules/login/views/login.php';
        }
        break;

    case '/register':
        AuthMiddleware::redirectIfLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require __DIR__ . '/modules/register/controllers/register.php';
        } else {
            require __DIR__ . '/modules/register/views/register.php';
        }
        break;

    case '/home':
        require __DIR__ . '/modules/home/views/home.php';
        break;

    case '/home/controllers/search_settings.php':
        require __DIR__ . '/modules/home/controllers/search_settings.php';
        break;

    case '/logout':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_destroy();
            setcookie('remember', '', time() - 3600, '/');
            header('Location: ' . url('login'));
            exit();
        }
        header('Location: ' . url('home'));
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/modules/404/404.php';
        break;
}
