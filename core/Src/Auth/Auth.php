<?php

namespace Src\Auth;

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

    public static function generateBearer(): string
    {
        $provider = new OAuthProvider();
        $token = $provider->generateToken(10);
        return $token;
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
        User::logout();
        session()->clear('id');
        return true;
    }

    public static function generateCSRF(): string
    {
        $token = md5(time());
        session()->set('csrf_token',$token);
        return $token;
    }



//    public function getAuthorizationHeader():string {
//        $headers = null;
//        if (isset($_SERVER['Authorization'])) {
//            $headers = trim($_SERVER["Authorization"]);
//        }
//        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
//            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
//        } elseif (function_exists('apache_request_headers')) {
//            $requestHeaders = apache_request_headers();
//            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
//            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
//            //print_r($requestHeaders);
//            if (isset($requestHeaders['Authorization'])) {
//                $headers = trim($requestHeaders['Authorization']);
//            }
//        }
//        return $headers;
//    }
//
//    public function getBearerToken() {
//        $headers = $this->getAuthorizationHeader();
//        // HEADER: Get the access token from the header
//        if (!empty($headers)) {
//            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
//                return $matches[1];
//            }
//        }
//        return null;
//    }
}

