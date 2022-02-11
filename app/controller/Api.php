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
        if (Auth::attemptApi($request->all())) {
            $api_token = User::where('username', $request->username)->first()['api_token'];
            (new View())->toJSON([$request->all(), 'your api_token' => $api_token]);
        }
        (new View())->toJSON([$request->all(), 'error' => 'invalid password or login']);
    }

    public function logout(Request $request): void
    {
        if (Auth::logoutApi()) {
            (new View())->toJSON(['message' => 'Успешный выход']);
        }
        (new View())->toJSON(['message' => 'Не аутентифицирован']);
    }

    public function diagnosis(Request $request): void
    {
        $diagnosis = Diagnoses::all();
        (new View())->toJSON(['даигнозы' => $diagnosis]);
    }
}
