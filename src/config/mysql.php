<?php
require_once __DIR__ . '/../../vendor/autoload.php';

function getConnection()
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();

    $username = $_ENV["DB_USERNAME"] ?? "root";
    $password = ($_ENV["DB_PASSWORD"] ?? "");
    $host = $_ENV["DB_HOST"] ?? "127.0.0.1";
    $database = $_ENV["DB_NAME"] ?? "knowai";
    $port = $_ENV["DB_PORT"] ?? 3306;

    $conn = new mysqli($host, $username, $password, $database, $port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

return getConnection();
