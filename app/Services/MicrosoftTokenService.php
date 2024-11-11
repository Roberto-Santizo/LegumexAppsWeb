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
         $guzzle = new \GuzzleHttp\Client();

         $url = 'https://login.microsoftonline.com/' . env('MICROSOFT_TENANT_ID') . '/oauth2/v2.0/token';
         $tokenResponse = $guzzle->post($url, [
             'form_params' => [
                 'client_id' => env('MICROSOFT_CLIENT_ID'),
                 'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
                 'scope' => 'https://graph.microsoft.com/.default',
                 'grant_type' => 'client_credentials',
             ],
         ]);
 
         $token = json_decode($tokenResponse->getBody()->getContents(), true);
         return $token['access_token'];
    }
}
