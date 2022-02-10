<?php

namespace Src\Auth;

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

        $id = session()->get('id')??0;
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
        session()->set('csrf_token',$token);
        return $token;
    }

}
