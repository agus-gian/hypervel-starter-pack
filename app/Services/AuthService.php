<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\AccountMail;
use App\Models\User;
use Hypervel\Http\Request;
use Hypervel\Support\Facades\DB;
use Hypervel\Support\Facades\Hash;
use Hypervel\Support\Facades\Log;
use Hypervel\Support\Facades\Mail;
use Hypervel\Validation\ValidationException;
use Throwable;
use Hypervel\HttpMessage\Exceptions;

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

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['User not found.']
            ]);
        }

        if (! $user->hasEmailVerified()) {
            throw ValidationException::withMessages([
                'email' => ['Please verify your email address.']
            ]);
        }

        if (! Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Password is incorrect.']
            ]);
        }

        if (! $user->active) {
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

    /**
     * @throws ValidationException
     * @throws Throwable
     */
    public function handleResendVerificationEmail(Request $request): void
    {
        try {
            $user = User::where('email', $request->input('email'))->first();

            if (! $user) {
                throw ValidationException::withMessages([
                    'email' => ['User not found.']
                ]);
            }

            if ($user->hasEmailVerified()) {
                throw ValidationException::withMessages([
                    'email' => ['Email already verified.']
                ]);
            }

            if (! $user->active) {
                throw ValidationException::withMessages([
                    'email' => ['User is not active.']
                ]);
            }

            $user->sendEmailVerificationNotification();

        } catch (Throwable $e) {
            Log::error('Error resend verification email', [$e]);

            throw $e;
        }
    }

    /**
     * @throws Throwable
     * @throws ValidationException
     */
    public function handleForgotPassword(Request $request): array
    {
        try {
            $user = User::where('email', $request->input('email'))->first();

            if (! $user) {
                throw ValidationException::withMessages([
                    'email' => ['User not found.']
                ]);
            }

            if ($user->hasEmailVerified()) {
                throw ValidationException::withMessages([
                    'email' => ['Email already verified.']
                ]);
            }

            if (! $user->active) {
                throw ValidationException::withMessages([
                    'email' => ['User is not active.']
                ]);
            }

            $token = bin2hex( random_bytes(32) );

            // Save token to database
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                ['token' => $token, 'created_at' => now()]
            );

            $mail = Mail::to($user->email)->send(new AccountMail([
                'view' => 'email.account_reset_notice',
                'subject' => 'Reset Password',
                'data' => [
                    'user' => $user,
                    'reset' => route('password.reset.edit', ['token' => $token, 'email' => $user->email]),
                ],
            ]));

            return [
                'user' => $user,
                'mail' => $mail->getDebug(),
            ];

        } catch (Throwable $e) {
            Log::error('Error forgot password', [$e]);

            throw $e;
        }
    }
}
