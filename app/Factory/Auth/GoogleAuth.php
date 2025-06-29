<?php

namespace App\Factory\Auth;

use Illuminate\Support\Facades\Http;

class GoogleAuth 
{
    // Define global url
    const AUTH_URL = 'https://accounts.google.com/o/oauth2/v2/auth?';
    const TOKEN_URL = 'https://oauth2.googleapis.com/token';
    const USER_INFO_URL = 'https://www.googleapis.com/oauth2/v3/userinfo';

    /**
     * Factory method redirect to Auth URL
     *
     * @return URL auth
     */
    // public function getRedirectUrl()
    // {
    //     $query = http_build_query([
    //         'client_id' => env('GOOGLE_CLIENT_ID'),
    //         'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
    //         'response_type' => 'code',
    //         'scope' => 'openid profile email',
    //     ]);
    //     // URL auth
    //     return  self::AUTH_URL . $query;
    // }

    /**
     * Factory method used to get authentication token in Google.
     *
     * @param string $code is obtained by parsing the parameters returned from Google Service.
     * @return string response access_token
     */
    public function getAccessToken(string $code)
    {
        $response = Http::asForm()->post(self::TOKEN_URL, [
            'code' => $code,
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
            'grant_type' => 'authorization_code',
        ]);

        return $response['access_token'];
    }

    /**
     * Factory method gets user information from Google Service's GraphQL.
     *
     * @param string $accessToken Get from the function above.
     * @return string json user infor
     */
    public function getUserInfo(string $accessToken)
    {
        return Http::withToken($accessToken)
            ->get(self::USER_INFO_URL)
            ->json();
    }
}
