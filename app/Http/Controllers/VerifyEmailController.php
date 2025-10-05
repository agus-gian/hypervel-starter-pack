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
    public function __invoke(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        $user->markEmailAsVerified();

        return to_route('verification.verify_success');
    }
}
