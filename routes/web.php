<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET','/profile', [Controller\Site::class, 'profile']);
Route::add('GET','/diagnosis', [Controller\Site::class, 'diagnosis']);
Route::add('GET','/appointments', [Controller\Site::class, 'appointments']);
Route::add(['GET','POST'],'/appointments/create', [Controller\Site::class, 'appointmentsCreate']);