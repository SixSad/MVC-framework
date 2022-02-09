<?php
namespace Controller;

use Src\Auth\Auth;
use Src\View;

class Authenticate
{
    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/');
    }

    public function profile(): string
    {
        return new View('site.profile');
    }
}
