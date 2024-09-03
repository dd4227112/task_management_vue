<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// Route::group(

//  protected routes

    Route::controller(UserController::class)->group(function () {
        //users
        Route::get('/user', 'index')->middleware( 'auth:sanctum');
        Route::post('/user', 'create');
    });
//projects
Route::controller(ProjectController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('project', 'index');
    Route::post('project', 'create');
    Route::put('project/{id}', 'update');
    Route::post('project/task', 'task');
    Route::post('project/task/pinToDashboard', 'pinToDashboard');
    Route::get('project/project_details/{slug}', 'project_details');
    Route::get('project/count', 'countProject');

});

//members
Route::controller(MemberController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('member', 'index');
    Route::post('member', 'create');
    Route::put('member/{id}', 'update');
});


//tasks
Route::controller(TaskController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('task', 'index');
    Route::post('task', 'create');
    Route::put('task/{id}', 'update');
    Route::post('task/changeTaskStatus', 'changeTaskStatus');

});

Route::post('/user/login', [UserController::class, 'login']);
