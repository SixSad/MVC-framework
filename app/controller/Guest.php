<?php
namespace Controller;

use Model\User;
use Src\View;
use Src\Request;
use Src\Validator\Validator;
use Src\Auth\Auth;

class Guest
{
    public function error403(): string
    {
        return new View('site.error403');
    }

    public function index(): string
    {
        return new View('site.index');
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'firstname' => ['required'],
                'lastname' => ['required'],
                'birth_date' => ['required', 'birthdate'],
                'username' => ['required', 'unique:users,username', 'latina'],
                'password' => ['required', 'length']
            ], [
                'required' => 'Поле: field пусто',
                'unique' => 'Поле: field должно быть уникально',
                'latina' => 'Поле: Логин принимает (a-z;0-9)',
                'length' => 'Поле: должно содержать минимум 8 символов',
                'birthdate' => 'Поле: введите правильную дату',
            ]);

            if ($validator->fails()) {
                return new View('site.signup',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (User::create($request->all())) {
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
    }

    public function login(Request $request): string
    {
        //Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        //Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/');
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }
}
