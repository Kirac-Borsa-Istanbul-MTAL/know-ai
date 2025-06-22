<?php

declare(strict_types=1);

namespace Services\Gemini;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GeminiService
{
    private const API_VERSION = 'v1beta';
    private const MODEL_NAME = 'gemini-2.0-flash';
    private const BASE_URL = 'https://generativelanguage.googleapis.com';

    private Client $httpClient;
    private string $apiKey;

    public function __construct(Client $httpClient, string $apiKey)
    {
        if (empty($apiKey)) {
            throw new Exception('Google API key not set in environment variables');
        }
        
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    public function generateContent(string $search, string $language = 'tr', string $searchLevel = '1'): array
    {
        $prompt = $this->generatePrompt($search, $language, $searchLevel);
        
        try {
            $response = $this->httpClient->post($this->buildApiUrl(), [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode([
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]),
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            
            if (isset($responseData['error'])) {
                throw new Exception($responseData['error']['message']);
            }

            return $responseData;
        } catch (GuzzleException $e) {
            throw new Exception("API request failed: " . $e->getMessage());
        }
    }

    private function generatePrompt(string $search, string $language, string $searchLevel): string
    {
        return staticPrompt($search, $language, $searchLevel);
    }

    private function buildApiUrl(): string
    {
        return sprintf(
            '%s/%s/models/%s:generateContent?key=%s',
            self::BASE_URL,
            self::API_VERSION,
            self::MODEL_NAME,
            $this->apiKey
        );
    }
}
