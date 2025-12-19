<?php

use Illuminate\Support\Facades\Cache;

class AuthSession
{

    public static function putUser($user)
    {
        return  Cache::add('user', $user);
    }

    public static function getUser()
    {
        return Cache::get('user');
    }
}
