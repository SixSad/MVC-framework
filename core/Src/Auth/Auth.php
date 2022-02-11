<?php

namespace Src\Auth;

use Illuminate\Support\Str;
use Model\User;
use function Session\session;


class Auth
{
    private static IdentityInterface $user;

    public static function init(IdentityInterface $user): void
    {
        self::$user = $user;
        if (self::user()) {
            self::login(self::user());
        }
    }

    public static function login(IdentityInterface $user): void
    {
        self::$user = $user;
        session()->set('id', self::$user->getId());
    }

    public static function attempt(array $credentials): bool
    {
        if ($user = self::$user->attemptIdentity($credentials)) {
            self::login($user);
            return true;
        }
        return false;
    }

    public static function role()
    {
        return self::user()['role_id'] ?? '';
    }

    public static function user()
    {
        $id = session()->get('id') ?? 0;
        return self::$user->findIdentity($id);
    }

    public static function check(): bool
    {
        if (self::user()) {
            return true;
        }
        return false;
    }

    public static function logout(): bool
    {
        session()->clear('id');
        return true;
    }

    public static function generateCSRF(): string
    {
        $token = md5(time());
        session()->set('csrf_token', $token);
        return $token;
    }

//Методы Api

    public static function loginApi(IdentityInterface $user): void
    {
        self::$user = $user;
        self::$user->api_token = Str::random(20);
        self::$user->save();
    }

    public static function logoutApi(): bool
    {
        if (!empty(self::userApi())) {
            self::$user = self::userApi();
            self::$user->api_token = NULL;
            self::$user->save();
            return true;
        }
        return false;
    }

    public static function attemptApi(array $credentials): bool
    {
        if ($user = self::$user->attemptIdentity($credentials)) {
            self::loginApi($user);
            return true;
        }
        return false;
    }

    public static function userApi()
    {
        $token = self::token();
        return self::$user->findIdentityApi($token) ?? null;
    }

    public static function token()
    {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $token = explode(' ', $headers['Authorization'])[1];
        }
        return $token ?? '';
    }

    public static function roleApi()
    {
        return self::userApi()['role_id'] ?? '';
    }

}

