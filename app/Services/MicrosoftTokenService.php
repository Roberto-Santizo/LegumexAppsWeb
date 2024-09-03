<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class MicrosoftTokenService
{
    protected $clientId;
    protected $clientSecret;
    protected $tenantId;
    public function __construct()
    {
        $this->clientId = config('services.microsoft.client_id');
        $this->clientSecret = config('services.microsoft.client_secret');
        $this->tenantId = config('services.microsoft.tenant_id');
    }

    public function getValidAccessToken()
    {
        $accessToken = Session::get('access_token');
        $tokenExpiresAt = Session::get('token_expires_at');

        // Verificar si el token ha expirado
        if ($tokenExpiresAt && now()->greaterThan($tokenExpiresAt)) {
            // Renovar el access token usando el refresh token
            $client = new Client();
            
            $response = $client->post("https://login.microsoftonline.com/12a61532-5685-4487-80dd-66d72c7ce3c6/oauth2/v2.0/token", [
                'form_params' => [
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'refresh_token' => Session::get('refresh_token'),
                    'grant_type' => 'refresh_token',
                    'scope' => 'https://graph.microsoft.com/.default',
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            // Actualizar los tokens en la sesión
            Session::put([
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
                'token_expires_at' => now()->addSeconds($data['expires_in']),
            ]);

            $accessToken = $data['access_token'];
        }

        return $accessToken;
    }
}
