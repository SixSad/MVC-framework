<?php

use Src\Route;

Route::add('GET', '/', [Controller\Site::class, 'index'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET','/profile', [Controller\Site::class, 'profile'])->middleware('auth');
Route::add(['GET','POST'],'/diagnosis', [Controller\Site::class, 'diagnosis'])->middleware('doctor');
Route::add(['GET','POST'],'/appointments', [Controller\Site::class, 'appointments'])->middleware('auth');
Route::add(['GET','POST'],'/appointments/create', [Controller\Site::class, 'appointmentsCreate'])->middleware('auth');
Route::add('GET', '/error403', [Controller\Site::class, 'error403']);
Route::add(['GET','POST'], '/create_user', [Controller\Site::class, 'create_user'])->middleware('admin');