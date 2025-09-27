<?php

declare(strict_types=1);

//use App\Http\Controllers\IndexController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use Hypervel\Permission\Middlewares\RoleMiddleware;
use Hypervel\Support\Facades\Route;

//Route::any('/', [IndexController::class, 'index']);

Route::group('/auth', function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    //TODO : create endpoint to resend mail verification & forgot password
});

Route::group('/user', function () {
    Route::get('/{id}/profile', [UserController::class, 'profile']);
    Route::get('/my-profile', [UserController::class, 'myProfile']);
}, ['middleware' => ['auth:sanctum', RoleMiddleware::using('member')]]);