<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Hyperf\ViewEngine\Contract\FactoryInterface;
use Hyperf\ViewEngine\Contract\ViewInterface;
use Hypervel\Http\Request;

class VerifyEmailController
{
    /**
     * Verify E-mail Handler.
     */
    public function __invoke(Request $request): string
    {
        $user = User::findOrFail($request->route('id'));

        $user->markEmailAsVerified();

        return route('verification.verify_success');
    }
}
