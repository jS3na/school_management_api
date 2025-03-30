<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('students', StudentController::class)->middleware('auth:sanctum');

Route::controller(StudentController::class)->middleware('auth:sanctum')->group(function () {
    Route::prefix('students')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
});

Route::controller(ClassController::class)->middleware('auth:sanctum')->group(function () {
    Route::prefix('classes')->group(function () {
        Route::get('/', 'index');
        Route::get('/students/{id}', 'students');
        Route::get('/{id}', 'show');
    });
});

Route::get('/teste', function () {
    return 'foi';
})->middleware('auth:sanctum');

Route::get('/login', function () {
    return 'login';
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login');
