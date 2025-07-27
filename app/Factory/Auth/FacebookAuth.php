<?php

namespace App\Factory\Auth;

use Illuminate\Support\Facades\Http;

class FacebookAuth {
    const USER_INFO_URL = 'https://graph.facebook.com/me';

    /**
     * Factory method gets user information from Facebook Service's GraphQL.
     *
     * @param string $accessToken Get from the function above.
     * @return array user infor
     */
    public function getUserInfo(string $accessToken)
    {
        $response = Http::get(self::USER_INFO_URL, [
            'fields' => 'id,name,email,picture',
            'access_token' => $accessToken,
        ])->json();
        return [
            "id" => $response['id'],
            "email" => !isset($response['email']) ? $response['id'] . "@facebook.com" : $response['email'],
            "name" => $response['name'],
            "picture" => $response['picture']['data']['url']
        ];
    }
}