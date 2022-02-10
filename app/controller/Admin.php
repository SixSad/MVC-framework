<?php

namespace Controller;

use function FileWork\fileWork;
use Model\User;
use Model\Diagnoses;
use Src\View;
use Src\Request;
use Src\Validator\Validator;

class Admin
{
    public function createUser(Request $request): string
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

    public function createDiagnosis(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'title' => ['required','latina'],
                'description' => ['required'],
            ], [
                'required' => 'Поле: field пусто',
                'latina' => 'Поле: field принимает (a-z;0-9)',
            ]);

            if ($validator->fails()) {
                return new View('site.add_diagnosis',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (fileWork()->checkUpload('file', app()->settings->getFilePath() . "/", 'out')) {
                $diagnosis = new Diagnoses();
                $diagnosis->title = $request->get('title');
                $diagnosis->description = $request->get('description');
                $diagnosis->image = fileWork()->rootToUpload('file', app()->settings->getFilePath() . "/", 'this');
                $diagnosis->save();

                return app()->route->redirect('/diagnosis');
                return false;
            }
            return new View('site.add_diagnosis',
                ['message' => "<h4 class='text-danger'>Не удалось загрузить файл</h4>"]);
        }
        return new View('site.add_diagnosis');
    }
}