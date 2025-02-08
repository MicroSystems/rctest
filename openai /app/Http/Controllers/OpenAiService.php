<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $client;
    protected $apiKey;
    protected $baseUri;

    public function __construct()
    {
        // Initialize the Guzzle HTTP Client
        $this->client = new Client();

        // Your OpenAI API key (ideally should be stored in .env)
        $this->apiKey = env('OPENAI_API_KEY');
        $this->baseUri = 'https://api.openai.com/v1/';
    }

    /**
     * Send a request to OpenAI API.
     *
     * @param string $model
     * @param string $prompt
     * @param int $maxTokens
     * @return array|null
     */
    public function generateResponse(string $model, string $prompt, int $maxTokens = 100)
    {
        try {
            // Request payload
            $response = $this->client->post($this->baseUri . 'completions', [
                'json' => [
                    'model' => $model,
                    'prompt' => $prompt,
                    'max_tokens' => $maxTokens,
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ]
            ]);

            // Parse the response and return it
            $body = json_decode($response->getBody()->getContents(), true);
            return $body['choices'][0]['text'] ?? null;

        } catch (ClientException $e) {
            // Handle client-side errors (4xx responses)
            Log::error('OpenAI Client Error: ' . $e->getMessage());
            return ['error' => 'Client error occurred. Please check your request.'];

        } catch (ServerException $e) {
            // Handle server-side errors (5xx responses)
            Log::error('OpenAI Server Error: ' . $e->getMessage());
            return ['error' => 'Server error occurred. Please try again later.'];

        } catch (RequestException $e) {
            // Handle general request errors
            Log::error('OpenAI Request Error: ' . $e->getMessage());
            return ['error' => 'Request failed. Please check your connection and try again.'];
        } catch (\Exception $e) {
            // Handle any other exceptions
            Log::error('OpenAI Unexpected Error: ' . $e->getMessage());
            return ['error' => 'An unexpected error occurred.'];
        }
    }
}
