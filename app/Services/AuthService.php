<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Hypervel\Http\Request;
use Hypervel\Support\Facades\Hash;
use Hypervel\Support\Facades\Log;
use Hypervel\Validation\ValidationException;
use Throwable;

class AuthService
{
    /**
     * Handle user login
     * @throws ValidationException
     * @throws Throwable
     */
    public function handleLogin(Request $request): array
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['User not found.']
            ]);
        }

        if (!$user->hasEmailVerified()) {
            throw ValidationException::withMessages([
                'email' => ['Please verify your email address.']
            ]);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Password is incorrect.']
            ]);
        }

        if (!$user->active) {
            throw ValidationException::withMessages([
                'email' => ['User is not active.']
            ]);
        }

        $apiToken = config('services.app_api.token');

        $accessToken = $user->createToken("{$apiToken}:{$user->email}")->plainTextToken;

        return [
            'user' => $user,
            'token' => $accessToken,
        ];
    }
}
