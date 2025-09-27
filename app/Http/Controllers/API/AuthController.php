<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserDetailResource;
use App\Services\AuthService;
use App\Services\UserService;
use Hypervel\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AuthController
{
    public function __construct(
        protected AuthService $authService,
        protected UserService $userService
    ){}

    /**
     * Register
     */
    public function register(RegisterRequest $request): ResponseInterface
    {
        try {
            $registerResponse = $this->userService->createUser($request);

            $userDetail = (new UserDetailResource($registerResponse))->withoutWrapping();

            return response()->json([
                'message' => 'Register successfully',
                'data' => $userDetail
            ]);

        } catch (Throwable $throwable) {

            return response()->json([
                'message' => $throwable->getMessage(),
                'data' => []
            ], $throwable->getCode());

        }
    }

    /**
     * Login
     */
    public function login(LoginRequest $request): ResponseInterface
    {
        try {
            $loginResponse = $this->authService->handleLogin($request);

            $access_token = $loginResponse['token'];
            $userDetail = (new UserDetailResource($loginResponse['user']))->withoutWrapping();

            return response()->json([
                'message' => 'Login successfully',
                'data' => [
                    'access_token' => $access_token,
                    'user' => $userDetail,
                ]
            ]);
        } catch (ValidationException $e) {

            return response()->json([
                'message' => 'Invalid data',
                'errors' => $e->errors()
            ], 422);

        } catch (Throwable $throwable) {

            return response()->json([
                'message' => $throwable->getMessage(),
                'data' => []
            ], $throwable->getCode());

        }
    }
}
