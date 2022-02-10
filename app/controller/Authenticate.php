<?php
namespace Controller;

use Src\Auth\Auth;
use Src\View;

class Authenticate
{
    public function logout(): string
    {
        Auth::logout();
        return app()->route->redirect('/');
    }

    public function profile(): string
    {
        return new View('site.profile');
    }
}
