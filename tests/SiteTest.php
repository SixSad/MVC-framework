<?php

use Model\Diagnoses;
use Model\User;
use PHPUnit\Framework\TestCase;
use Src\Auth\Auth;

class SiteTest extends TestCase
{

    /**
     * @dataProvider additionProviderSignup
     */
    public function testSignup(string $httpMethod, array $userData, string $message): void
    {
        //Выбираем занятый логин из базы данных
        if ($userData['username'] === 'login is busy') {
            $userData['username'] = User::get()->first()->username;
        }

        // Создаем заглушку для класса Request.
        $request = $this->createMock(\Src\Request::class);
        // Переопределяем метод all() и свойство method
        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;

        //Сохраняем результат работы метода в переменную
        $result = (new \Controller\Guest())->signup($request);

        if (!empty($result)) {
            //Проверяем варианты с ошибками валидации
            $message = '/' . preg_quote($message, '/') . '/';
            $this->expectOutputRegex($message);
            return;
        }

        //Проверяем добавился ли пользователь в базу данных
        $this->assertTrue((bool)User::where('username', $userData['username'])->count());
        //Удаляем созданного пользователя из базы данных
        User::where('username', $userData['username'])->delete();


        //Проверяем редирект при успешной регистрации
        $this->assertContains($message, xdebug_get_headers());
    }

    public function additionProviderSignup(): array
    {
        return [
            ['GET', ['firstname' => '', 'lastname' => '', 'username' => '', 'password' => '', 'birth_date' => ''],
                '<h3></h3>'
            ],
            ['POST', ['firstname' => '', 'lastname' => '', 'username' => '', 'password' => '', 'birth_date' => ''],
                '<h3>{"name":["Поле name пусто"],"login":["Поле login пусто"],"password":["Поле password пусто"]}</h>',
            ],
            ['POST', ['firstname' => 'admin', 'lastname' => 'admin', 'username' => 'login is busy', 'password' => 'admin', 'birth_date' => ''],
                '<h3>{"login":["Поле login должно быть уникально"]}</h3>',
            ],
            ['POST', ['firstname' => 'admin', 'lastname' => 'admin', 'username' => md5(time()), 'password' => 'admin', 'birth_date' => ''],
                'Location: /practice/login/'
            ],
        ];
    }


    /**
     * @dataProvider additionProviderLogin
     */
    public function testLogin(string $httpMethod, array $userData, string $message): void
    {
        // Создаем заглушку для класса Request.
        $request = $this->createMock(\Src\Request::class);
        // Переопределяем метод all() и свойство method
        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;

        //Сохраняем результат работы метода в переменную
        $result = (new \Controller\Guest())->login($request);

        if (!empty($result)) {
            //Проверяем варианты с ошибками валидации
            $message = '/' . preg_quote($message, '/') . '/';
            $this->expectOutputRegex($message);
            return;
        }
        //Проверяем добавился ли пользователь в базу данных
        $this->assertTrue((bool)Auth::user());

        //Проверяем редирект при успешной регистрации
        $this->assertContains($message, xdebug_get_headers());

    }

    public function additionProviderLogin(): array
    {
        return [
            ['GET', ['username' => '', 'password' => ''],
                '<h3></h3>'
            ],
            ['POST', ['username' => '', 'password' => ''],
                '<h3>{"username":["Поле username пусто"],"password":["Поле password пусто"]}</h3>',
            ],
            ['POST', ['username' => md5(time()), 'password' => 'admin'],
                '<h3>Неправильные логин или пароль</h3>',
            ],
            ['POST', ['username' => 'qwe1', 'password' => 'qwe1'],
                'Location: /practice/'
            ],
        ];
    }


    /**
     * @dataProvider additionProviderCreateDiagnosis
     */
    public function testCreateDiagnosis(string $httpMethod, array $userData, string $message): void{

        if ($userData['file'] === 'blank') {
            $_FILES = [
                'file' => [
                    'name' => 'zxc.png',
                    'type' => 'image/png',
                    'size' => 5093,
                    'tmp_name' => 'asdasdasdasd',
                    'error' => 0
                ]
            ];
        }

        $request = $this->createMock(\Src\Request::class);

        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;

        $result = (new \Controller\Admin())->createDiagnosis($request);

        if (!empty($result)) {
            $message = '/' . preg_quote($message, '/') . '/';
            $this->expectOutputRegex($message);
            return;
        }

        $this->assertTrue((bool)Diagnoses::where('title', $userData['title'])->count());

        Diagnoses::where('title', $userData['title'])->delete();

        $this->assertContains($message, xdebug_get_headers());
    }

    public function additionProviderCreateDiagnosis(): array    {
        return [
            ['GET', ['title' => '', 'description' => '','file'=>''],
                '<h3></h3>'
            ],
            ['POST', ['title' => '', 'description' => '','file'=>''],
                '<h3>{"title":["Поле username пусто"],"description":["Поле password пусто"]}</h3>',
            ],
            ['POST', ['title' => 'фыв', 'description' => 'blank','file'=>''],
                '<h3>{"title":["Поле: field принимает (a-z;0-9)"]</h3>',
            ],
            ['POST', ['title' => 'blank', 'description' => 'blank','file'=>'blank'],
                'Location: /practice/diagnosis/'
            ],
        ];
    }


    protected function setUp(): void
    {
        //Установка переменной среды
        $_SERVER['DOCUMENT_ROOT'] = 'C:\xampp\htdocs';

        //Создаем экземпляр приложения
        $GLOBALS['app'] = new Src\Application(new Src\Settings([
            'app' => include $_SERVER['DOCUMENT_ROOT'] . '/practice/config/app.php',
            'db' => include $_SERVER['DOCUMENT_ROOT'] . '/practice/config/db.php',
            'path' => include $_SERVER['DOCUMENT_ROOT'] . '/practice/config/path.php',
        ]));

        //Глобальная функция для доступа к объекту приложения
        if (!function_exists('app')) {
            function app()
            {
                return $GLOBALS['app'];
            }
        }
    }
}
