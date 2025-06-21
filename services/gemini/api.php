<?php
    require_once __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/prompt.php';
    
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $search = isset($_POST['search']) ? $_POST['search'] : '';
        if (empty($search)) {
            echo json_encode(['error' => 'No search query provided']);
            exit;
        }
        
        try {
            $result = apiCall($search);
            echo json_encode(['success' => true, 'data' => $result]);
            exit;
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
    
    function apiCall($search) {
        $language = isset($_COOKIE['preferred_language']) ? $_COOKIE['preferred_language'] : 'tr';
        $searchLevel = isset($_COOKIE['searchLevel']) ? $_COOKIE['searchLevel'] : '1';
        $prompt = staticPrompt($search, $language, $searchLevel);
        
        $apiKey = $_ENV['GEMINI_API_KEY'];
        if (!$apiKey) {
            throw new Exception('Google API key not set in environment variables');
        }

        $client = new \GuzzleHttp\Client();

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $responseHttp = $client->post($url, [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode([
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt
                            ]
                        ]
                    ]
                ]
            ]),
        ]);

        $responseData = json_decode($responseHttp->getBody()->getContents(), true);
        if (isset($responseData['error'])) {
            throw new Exception($responseData['error']['message']);
        }

        return $responseData;
    }
