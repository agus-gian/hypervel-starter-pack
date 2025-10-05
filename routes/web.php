<?php

declare(strict_types=1);

use Hypervel\Support\Facades\Route;

Route::get('/email/verify/{id}/{hash}', [
    'as' => 'verification.verify',
    'uses' => '\App\Http\Controllers\VerifyEmailController@__invoke'
]);

Route::get('/email/verify/success', ['as' => 'verification.verify_success', function () {
    return view('email.verify_success');
}]);

Route::get('/reset-password/{token}', ['as' => 'password.reset.edit', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
}]);

Route::post('/reset-password', [
    'as' => 'password.reset.update',
    'uses' => '\App\Http\Controllers\ResetPasswordController@reset'
]);

Route::get('/', ['as' => 'home', function () {
    return view('welcome');
}]);