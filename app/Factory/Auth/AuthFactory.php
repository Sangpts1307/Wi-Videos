<?php

namespace App\Factory\Auth;

class AuthFactory
{
    public function make($provider)
    {
        switch ($provider) {
            case 'google':
                return new GoogleAuth();
            case 'facebook':
                return new FacebookAuth();
            default:
                return "Auth Provider is not supported!";
        }
    }
}
