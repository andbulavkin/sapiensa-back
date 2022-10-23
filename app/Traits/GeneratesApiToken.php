<?php

namespace App\Traits;

use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

trait GeneratesApiToken
{
    /**
     * Request access token
     *
     * @param string $username
     * @param string $password
     */
    public function requestAccessToken(string $email, string $password)
    {
        $uri = url('/oauth/token');

        $http = new \GuzzleHttp\Client();
        // dd($uri);
        try {
            $response = $http->post($uri, [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('app.client_id'),
                    'client_secret' => config('app.client_secret'),
                    'username' => $email,
                    'password' => $password,
                    'scope' => '*',
                ],
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (GuzzleException $exception) {
            if (400 === $exception->getCode()) {
                throw new UnauthorizedHttpException('', 'Incorrect email or password');
            }
        }
    }


    public function refreshAuthToken(string $refreshToken)
    {
        $http = new \GuzzleHttp\Client;

        try {
            $response = $http->post(url('oauth/token'), [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id' => config('app.client_id'),
                    'client_secret' => config('app.client_secret'),
                ],
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (GuzzleException $e) {
            if ($e->getCode() === 401) {
                throw new HttpException($e->getCode(), 'Either refresh token is expired or revoked');
            }
        }
    }


}
