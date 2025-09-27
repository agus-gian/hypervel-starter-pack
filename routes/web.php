<?php

declare(strict_types=1);

use Hypervel\Support\Facades\Route;

Route::get('/email/verify/{id}/{hash}', [
    'as' => 'verification.verify', 'uses' => 'VerifyEmailController@__invoke'
]);

Route::get('/email/verify/success', ['as' => 'verification.verify_success', function () {
    return view('email.verify_success');
}]);

Route::get('/', ['as' => 'home', function () {
    return view('welcome');
}]);