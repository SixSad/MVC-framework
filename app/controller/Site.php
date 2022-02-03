<?php

namespace Controller;

use http\Message;
use Model\Appointments;
use Model\User;
use Model\Post;
use Model\Diagnoses;
use Src\View;
use Src\Request;
use Src\Auth\Auth;

class Site
{
    public function index(Request $request): string
    {
        $posts = Post::all();
        return (new View())->render('site.index', ['posts' => $posts]);
    }

    public function hello(): string
    {
        return new View('site.index', ['message' => 'hello working']);
    }

    public function signup(Request $request): string
    {
        $errors = [];
        foreach ($_POST as $key => $value){
            if(empty($value)){
                array_push($errors,$key);
            }
        }
        if($errors){
            return new View('site.signup', ['message' => 'Заполните все поля']);
        }
        if ($request->method === 'POST' && User::where('username',$request->password)->first()) {
            return new View('site.signup', ['message' => 'Данный пользователь зарегистрирован']);
        }


        if ($request->method === 'POST' && User::create($request->all())) {
            app()->route->redirect('/hello');
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
            app()->route->redirect('/hello');
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function profile(): string{
        return new View('site.profile');
    }

    public function appointments(): string{
        $appointments = Appointments::all();
        return (new View())->render('site.appointments', ['appointments' => $appointments]);
    }

    public function diagnosis(): string{
        $diagnosis = Diagnoses::all();
        return (new View())->render('site.diagnosis', ['diagnosis' => $diagnosis]);
    }

    public function appointmentsCreate(Request $request): string{
        if ($request->method === 'POST') {
            app()->route->redirect('/hello');
        }
        return new View('site.new_appointment');
    }

}
