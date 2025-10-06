<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Hypervel\Http\Request;
use Hypervel\Support\Carbon;
use Hypervel\Support\Facades\DB;
use Hypervel\Support\Facades\Hash;
use Hypervel\Validation\Rules\Password;
use Hypervel\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;

class ResetPasswordController
{
    /**
     * @throws ValidationException
     */
    public function reset(Request $request): ResponseInterface
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        $token = $request->input('token');
        $email = $request->input('email');
        $password = $request->input('password');

        $resetToken = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (! $resetToken) {
            $request->session()->flash('error', 'Token not found.');

            return to_route('password.reset.edit',['token' => $token, 'email' => $email]);
        }

        if ($token <> $resetToken->token) {
            $request->session()->flash('error', 'Invalid password reset token.');

            return to_route('password.reset.edit',['token' => $token, 'email' => $email]);
        }

        if (Carbon::parse($resetToken->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            $request->session()->flash('error', 'Token has expired.');

            return to_route('password.reset.edit',['token' => $token, 'email' => $email]);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            $request->session()->flash('error', 'User not found.');

            return to_route('password.reset.edit',['token' => $token, 'email' => $email]);
        }

        // Update user password
        $user->password = Hash::make($password);
        $user->save();

        // Delete token after successful change
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        $request->session()->flash('success', 'Password reset successfully.');

        return to_route('password.reset.edit', ['token' => $token, 'email' => $email]);
    }
}
