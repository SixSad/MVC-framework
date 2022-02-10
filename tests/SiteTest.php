<?php

use Model\User;
use PHPUnit\Framework\TestCase;

class SiteTest extends TestCase
{
    /**
     * @dataProvider additionProviderSignup
     */
    public function testSignup(string $httpMethod, array $userData, string $message): void
    {
        //Выбираем занятый логин из базы данных
        if ($userData['username'] === 'login is busy') {
            $userData['username'] = User::get()->first()->login;
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
        $this->assertTrue((bool)User::where('login', $userData['login'])->count());
        //Удаляем созданного пользователя из базы данных
        User::where('login', $userData['login'])->delete();


        //Проверяем редирект при успешной регистрации
        $this->assertContains($message, xdebug_get_headers());
    }

//Метод, возвращающий набор тестовых данных
    public function additionProviderSignup(): array
    {
        return [
            ['GET', ['firstname' => '', 'lastname' => '', 'username' => '', 'password' => '', 'birth_date'=>''],
                '<h3></h3>'
            ],
            ['POST', ['firstname' => '', 'lastname' => '', 'username' => '', 'password' => '','birth_date'=>''],
                '<h3>{"name":["Поле name пусто"],"login":["Поле login пусто"],"password":["Поле password пусто"]}</h3>',
            ],
            ['POST', ['firstname' => 'admin', 'lastname' => 'admin', 'username' => 'login is busy', 'password' => 'admin','birth_date'=>''],
                '<h3>{"login":["Поле login должно быть уникально"]}</h3>',
            ],
            ['POST', ['firstname' => 'admin', 'lastname' => 'admin', 'username' => md5(time()), 'password' => 'admin','birth_date'=>''],
                'Location: /pop-it-mvc/hello',
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
