<?php

namespace Controller;

use Illuminate\Support\Str;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class Api
{
    public function index(): void
    {
        $posts = User::all()->toArray();

        (new View())->toJSON($posts);
    }

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }

    public function login(Request $request): void
    {
        if ($request->method === 'POST') {
            if (Auth::attempt($request->all())) {
                User::where('username',$request->get('username'))->first()->update(['api_token'],Str::random(20));
            }
            (new View())->toJSON($request->all());
        }
    }
}
