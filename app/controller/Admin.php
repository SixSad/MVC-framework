<?php
namespace Controller;


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
                'title' => ['required'],
                'description' => ['required'],
            ], [
                'required' => 'Поле: field пусто',
            ]);

            if ($validator->fails()) {
                return new View('site.add_diagnosis',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }
            $image = new User;
            if ($_FILES['file']['error'] == 0) {
                if ($image->saveFromTemp('file',app()->settings->getFilePath())) {
                    $diagnosis = new Diagnoses();
                    $diagnosis->title = $request->get('title');
                    $diagnosis->description = $request->get('description');
                    $diagnosis->image = $image->getTemplate('file',app()->settings->getFilePath());
                    $diagnosis->save();
                    return new View('site.add_diagnosis',
                        ['message' => 'Диагноз добавлен']);
                }
            } else {
                return new View('site.add_diagnosis',
                    ['message' => "<h4 class='text-danger'>Не удалось загрузить файл</h4>"]);
            }


            return new View('site.add_diagnosis');
        }
        return new View('site.add_diagnosis');
    }
}