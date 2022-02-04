<?php
return [
    'auth' => \Src\Auth\Auth::class,
    'identity' => \Model\User::class,
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'doctor' => \Middlewares\DoctorMiddleware::class,
        'admin' => \Middlewares\AdminMiddleware::class,
    ]
];
