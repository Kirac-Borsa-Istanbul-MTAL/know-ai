<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/prompt.php';
require_once __DIR__ . '/GeminiService.php';

use Services\Gemini\GeminiService;
use GuzzleHttp\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

header('Content-Type: application/json');

function handleRequest(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendJsonResponse(['error' => 'Method not allowed'], 405);
        return;
    }

    $search = filter_input(INPUT_POST, 'search') ?? '';
    $search = htmlspecialchars(trim($search), ENT_QUOTES, 'UTF-8');

    if (empty($search)) {
        sendJsonResponse(['error' => 'No search query provided'], 400);
        return;
    }

    try {
        $geminiService = new GeminiService(
            new Client(),
            $_ENV['GEMINI_API_KEY'] ?? throw new Exception('API key not configured')
        );

        $language = $_COOKIE['preferred_language'] ?? 'tr';
        $searchLevel = $_COOKIE['searchLevel'] ?? '1';

        $result = $geminiService->generateContent($search, $language, $searchLevel);
        sendJsonResponse(['success' => true, 'data' => $result]);
    } catch (Exception $e) {
        sendJsonResponse(['error' => $e->getMessage()], 500);
    }
}

function sendJsonResponse(array $data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    echo json_encode($data, JSON_THROW_ON_ERROR);
    exit;
}

handleRequest();
