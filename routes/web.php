<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});
Route::get('/validateemail/{token}', [UserController::class, 'validateemail']);
Route::get('app/login', function () {
    return view('login');
});
Route::get('{param1}', function () {
    return view('welcome');
});
Route::get('{param1}/{param2}', function () {
    return view('welcome');
});
Route::get('{param1}/{param2}/{param3}', function () {
    return view('welcome');
});