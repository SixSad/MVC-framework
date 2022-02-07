<?php

namespace Controller;

use http\Message;
use Illuminate\Support\Facades\App;
use Model\Appointments;
use Model\User;
use Model\Post;
use Model\Diagnoses;
use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Src\Validator\Validator;

class Site
{
    public function index(Request $request): string
    {
        return new View('site.index');
    }


//    public function signup(Request $request): string
//    {
//        $errors = [];
//        foreach ($_POST as $key => $value){
//            if(empty($value)){
//                array_push($errors,$key);
//            }
//        }
//        if($errors){
//            return new View('site.signup', ['message' => 'Заполните все поля']);
//        }
//        if ($request->method === 'POST' && User::where('username',$request->password)->first()) {
//            return new View('site.signup', ['message' => 'Данный пользователь зарегистрирован']);
//        }
//
//
//        if ($request->method === 'POST' && User::create($request->all())) {
//            app()->route->redirect('/hello');
//        }
//
//
//        return new View('site.signup');
//    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'firstname' => ['required'],
                'lastname' => ['required'],
                'birth_date' => ['required','birthdate'],
                'username' => ['required', 'unique:users,username', 'latina'],
                'password' => ['required', 'length']
            ], [
                'required' => 'Поле: field пусто',
                'unique' => 'Поле: field должно быть уникально',
                'latina' => 'Поле: Логин принимает (a-z;0-9)',
                'length' => 'Поле: должно содержать минимум 8 символов',
                'birthdate'=>'Поле: введите правильную дату',
            ]);

            if($validator->fails()){
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

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/');
    }

    public function profile(): string{
        return new View('site.profile');
    }

    public function patientAppointments(Request $request): string{
        $user =  app()->auth::user()->id;
        if($request ->method === 'GET') {
            $appointments = Appointments::where('patient_id',$user)->get();
            if (!empty($_GET['search_patient'])) {
                $q = $request->get('search_patient');
                $user = User::where(['firstname'=>$q],['lastname'=>$q])->first();
                if(!empty($user)){
                    $appointments = Appointments::where('patient_id',$user['id'])->get();
                }
                else{
                    $appointments = [];
                }
            }
            if (!empty($_GET['search_date'])) {
                $q = $request->get('search_date');
                $appointments = Appointments::where('date',$q)->get();
            }
            return (new View())->render('site.patientAppointments', ['appointments' => $appointments]);
        }
    }

    public function doctorAppointments(Request $request): string{
        if($request ->method === 'GET') {
            $appointments = Appointments::all();
            if (!empty($_GET['search_patient'])) {
                $q = $request->get('search_patient');
                $user = User::where(['firstname'=>$q],['lastname'=>$q])->first();
                if(!empty($user)){
                    $appointments = Appointments::where('patient_id',$user['id'])->get();
                }
                else{
                    $appointments = [];
                }
            }
            if (!empty($_GET['search_date'])) {
                $q = $request->get('search_date');
                $appointments = Appointments::where('date',$q)->get();
            }
            return (new View())->render('site.doctorAppointments', ['appointments' => $appointments]);
        }
    }

    public function diagnosis(Request $request): string{
        if($request ->method === 'GET') {
            if(!empty($_GET['search'])) {
                $q = $request->get('search');
                $diagnosis = Diagnoses::where('title', $q)->get();
                return (new View())->render('site.diagnosis', ['diagnosis' => $diagnosis]);
            }
            else{
                $diagnosis = Diagnoses::all();
                return (new View())->render('site.diagnosis', ['diagnosis' => $diagnosis]);
            }
        }
    }

    public function appointmentsCreate(Request $request): string
    {
        $doctors = User::where('role_id', '2')->get();
        if ($request->method === 'GET') {
            return (new View())->render('site.new_appointment', ['doctors' => $doctors]);
        }

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'date' => ['date'],
                'doctor_id' => ['required']
            ], [
                'required' => 'Поле: field пусто',
                'date' => 'Поле: введите корректную дату',

            ]);

            if ($validator->fails()) {
                return new View('site.new_appointment',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE), 'doctors' => $doctors]);
            }

            if (Appointments::create($request->all())) {
                return new View('site.new_appointment',
                    ['message' => "<p class='text-success'>Вы записались на прием</p>", 'doctors' => $doctors]);
            }
        }
    }

    public function error403(): string{
        return new View('site.error403');
    }

    public function create_user(Request $request): string
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
                return new View('site.create_user',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }
            if (User::create($request->all())) {
                return new View('site.create_user',
                    ['message' => "<p class='text-success'>Пользователь успешно создан</p>"]);
            }
        }
        return new View('site.create_user');
    }

    public function update_diagnosis(Request $request): string
    {
        $id = $request->get('id');
        $diagnosis = Diagnoses::all();
        $form = Appointments::where('id',$id)->first();
        $patient = User::where('id',$form['patient_id'])->first();
        if($request->method ==='GET'){
            return new View('site.update_diagnosis',['form'=>$form,'patient'=>$patient,'diagnosis'=>$diagnosis]);
        }

        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'diagnosis' => ['required']
            ], [
                'required' => 'Поле: field пусто',
            ]);

            if ($validator->fails()) {
                return new View('site.update_diagnosis',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE), 'form'=>$form,'patient'=>$patient,'diagnosis'=>$diagnosis]);
            }
            $form = Appointments::where('id',$id)->first();
            $form->diagnosis=$request->get('diagnosis');
            $form->save();
            app()->route->redirect('/appointmentsd');

//            $form = Appointments::where('id',$request->get('id'))->first();
//            $form->dia ='dfdf';
//            $form->save();
        }

    }
}
