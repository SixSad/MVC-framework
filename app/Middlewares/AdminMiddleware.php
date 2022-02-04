<?php

namespace Middlewares;
use Model\Role;
use Src\Auth\Auth;
use Src\Request;

class AdminMiddleware
{
    public function handle(Request $request)
    {
        if (Role::where('id', Auth::role())->first()['role_code'] !== 'admin') {
            app()->route->redirect('/error403');
        }
    }
}