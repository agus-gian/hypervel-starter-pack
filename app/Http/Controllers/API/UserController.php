<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Resources\User\UserDetailResource;
use App\Services\UserService;
use Hypervel\Support\Facades\Auth;
use Psr\Http\Message\ResponseInterface as ResponseInterfaceAlias;
use Throwable;

//use Hypervel\Http\Request;

class UserController
{
    public function __construct(
        protected UserService $userService,
    ){}

    /**
     * Display the specified resource.
     */
    public function profile(string $id): ResponseInterfaceAlias
    {
        try {

            $detailUser = $this->userService->detailUser($id);

            return (new UserDetailResource($detailUser))->withoutWrapping();

        } catch (Throwable $e) {

            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ],$e->getCode());

        }
    }

    public function myProfile(): UserDetailResource
    {
        $authUser = Auth::user();

        return (new UserDetailResource($authUser))->withoutWrapping();
    }
}
