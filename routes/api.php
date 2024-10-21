<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TodoController;

Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('todo', TodoController::class);
    Route::post('logout', [UserController::class, 'logout']);
});

Route::controller(UserController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});