<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Hypervel\Http\Request;
use Hypervel\Support\Facades\DB;
use Hypervel\Support\Facades\Hash;
use Hypervel\Support\Facades\Log;
use Throwable;
use Exception;

class UserService
{
    /**
     * Create user member
     * @throws Throwable
     */
    public function createUser(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            $user->assignRole('member');

            $user->sendEmailVerificationNotification();

            return $user;
        });
    }

    /**
     * Detail User
     * @throws Throwable
     */
    public function detailUser(string $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            throw new Exception('User not found',404);
        }

        if (!$user->active) {
            throw new Exception('User not active',400);
        }

        if (!$user->hasEmailVerified()) {
            throw new Exception('User not verify the email',400);
        }

        if ($user->hasAnyRoles(['super-admin', 'admin'])) {
            throw new Exception('User not found',404);
        }

        return $user;
    }
}
