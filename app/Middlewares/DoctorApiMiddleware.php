<?php
namespace Middlewares;

use Model\Role;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\View;
use function Collect\collection;

class DoctorApiMiddleware
{

    public function handle(Request $request)
    {
        if (Role::where('id', Auth::role())->first()['role_code'] !== 'doctor') {
            return (new View())->toJSON(['error'=>'forbidden for you']);
        }
    }
}
