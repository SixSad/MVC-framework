<?php

namespace Middlewares;
use Model\Role;
use Src\Auth\Auth;
use Src\Request;

class DoctorMiddleware
{
    public function handle(Request $request)
    {
        if (!in_array(Role::where('id', Auth::role())->first()['role_code'],['doctor','admin'])){
            app()->route->redirect('/error403');
        }
    }
}