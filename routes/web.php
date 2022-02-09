<?php

use Src\Route;

Route::add('GET', '/', [Controller\Guest::class, 'index'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Guest::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Guest::class, 'login']);
Route::add('GET', '/logout', [Controller\Guest::class, 'logout']);
Route::add('GET', '/error403', [Controller\Guest::class, 'error403']);
Route::add('GET','/profile', [Controller\Patient::class, 'profile'])->middleware('auth');
Route::add(['GET','POST'],'/appointmentsp', [Controller\Patient::class, 'patientAppointments'])->middleware('auth');
Route::add(['GET','POST'],'/appointments/create', [Controller\Patient::class, 'appointmentsCreate'])->middleware('auth');
Route::add(['GET','POST'],'/appointments/create', [Controller\Patient::class, 'logout'])->middleware('auth');
Route::add(['GET','POST'],'/diagnosis', [Controller\Doctor::class, 'diagnosis'])->middleware('doctor');
Route::add(['GET','POST'],'/appointmentsd', [Controller\Doctor::class, 'doctorAppointments'])->middleware('doctor');
Route::add(['GET','POST'], '/diagnosis/update', [Controller\Doctor::class, 'update_diagnosis'])->middleware('doctor');
Route::add(['GET','POST'], '/create_user', [Controller\Admin::class, 'create_user'])->middleware('admin');
Route::add(['GET','POST'], '/diagnosis/create', [Controller\Admin::class, 'create_diagnosis'])->middleware('doctor');