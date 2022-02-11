<?php

namespace Controller;

use Illuminate\Support\Str;
use Model\Diagnoses;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\Validator\Validator;
use Src\View;
use function Illuminate\Events\queueable;

class Api
{
    public function index(): void
    {
        $posts = User::all()->toArray();

        (new View())->toJSON($posts);
    }

    public function login(Request $request): void
    {
        if ($request->method === 'POST') {

            if (Auth::attempt($request->all())) {
                $api_token = Str::random(20);
                User::where('username', $request->get('username'))->update(['api_token' => $api_token]);
            }
            (new View())->toJSON([$request->all(), 'your api_token' => $api_token]);
        }
    }

    public function logout(Request $request): void
    {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $api_token = explode(' ', $headers['Authorization'])[1];
        }
        if (!empty($api_token)){
            User::where('api_token', $api_token)->update(['api_token' => NULL]);
            (new View())->toJSON(['message' => 'Выход']);
        }
        (new View())->toJSON(['message' => 'Не авторизован']);
    }

    public function diagnosis(Request $request): void
    {
        $diagnosis = Diagnoses::all();
        (new View())->toJSON(['даигнозы' => $diagnosis]);
    }
}
