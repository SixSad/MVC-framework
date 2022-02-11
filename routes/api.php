<?php

use Src\Route;


Route::group('/api', function () {
    Route::add('GET', '/z', [Controller\Api::class, 'index'])->middleware('token');
    Route::add('GET', '/diagnosis', [Controller\Api::class, 'diagnosis'])->middleware('token','doctorApi');
    Route::add('POST', '/login', [Controller\Api::class, 'login']);
    Route::add('GET', '/logout', [Controller\Api::class, 'logout']);
});

