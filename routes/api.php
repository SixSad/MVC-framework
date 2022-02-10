<?php

use Src\Route;

Route::add('GET', '/z', [Controller\Api::class, 'index'])->middleware('json');
Route::add('POST', '/echo', [Controller\Api::class, 'echo'])->middleware('json');;
Route::add('POST', '/login', [Controller\Api::class, 'login'])->middleware('json');;