<?php
return [
    'auth' => \Src\Auth\Auth::class,
    'identity' => \Model\User::class,
    'routeAppMiddleware' => [
        'trim' => \Middlewares\TrimMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'json' => \Middlewares\JSONMiddleware::class,
    ],
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'doctor' => \Middlewares\DoctorMiddleware::class,
        'admin' => \Middlewares\AdminMiddleware::class,
        'token' => \Middlewares\TokenMiddleware::class,
        'doctorapi' => \Middlewares\DoctorApiMiddleware::class,
    ],
    'validators' => [
        'required' => \Validators\RequireValidator::class,
        'unique' => \Validators\UniqueValidator::class,
        'latina' => \Validators\LatinaValidator::class,
        'length' => \Validators\LengthValidator::class,
        'date' => \Validators\DateValidator::class,
        'birthdate' => \Validators\BirthdateValidator::class,
    ],
    'providers' => [
        'kernel' => \Providers\KernelProvider::class,
        'route' => \Providers\RouteProvider::class,
        'db' => \Providers\DBProvider::class,
        'auth' => \Providers\AuthProvider::class,
    ],
];
