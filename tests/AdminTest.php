<?php

use Model\Diagnoses;
use Model\User;
use PHPUnit\Framework\TestCase;
use Src\Auth\Auth;

class AdminTest extends TestCase
{

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
                '<h3>{"title":["Поле: field принимает (a-z;0-9)"]}</h3>',
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
