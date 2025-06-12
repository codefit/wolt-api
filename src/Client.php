<?php

namespace Wolt\Api;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Wolt\Api\Exception\AuthenticationException;

class Client
{
    private const BASE_URL = 'https://pos-integration-service.wolt.com';
    private const AUTH_URL = 'https://auth.wolt.com/oauth2/token';

    private HttpClient $httpClient;
    private string $clientId;
    private string $clientSecret;
    private ?string $accessToken = null;
    private ?int $tokenExpiresAt = null;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->httpClient = new HttpClient([
            'base_uri' => self::BASE_URL,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Get access token for API requests
     *
     * @throws AuthenticationException
     */
    private function getAccessToken(): string
    {
        if ($this->accessToken && $this->tokenExpiresAt && $this->tokenExpiresAt > time()) {
            return $this->accessToken;
        }

        try {
            $response = $this->httpClient->post(self::AUTH_URL, [
                'auth' => [$this->clientId, $this->clientSecret],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            
            if (!isset($data['access_token'])) {
                throw new AuthenticationException('Invalid authentication response');
            }

            $this->accessToken = $data['access_token'];
            $this->tokenExpiresAt = time() + ($data['expires_in'] ?? 3600);

            return $this->accessToken;
        } catch (GuzzleException $e) {
            throw new AuthenticationException('Failed to authenticate: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Make an authenticated request to the API
     *
     * @throws GuzzleException
     */
    protected function request(string $method, string $uri, array $options = []): array
    {
        $options['headers']['Authorization'] = 'Bearer ' . $this->getAccessToken();
        
        $response = $this->httpClient->request($method, $uri, $options);
        return json_decode($response->getBody()->getContents(), true);
    }
} 