<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResendVerificationEmailRequest;
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
            ], 500);

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
            ], 500);

        }
    }

    /**
     * Resend Verification Email
     */
    public function resendVerificationEmail(ResendVerificationEmailRequest $request): ResponseInterface
    {
        try {
            $this->authService->handleResendVerificationEmail($request);

            return response()->json([
                'message' => 'Verification email sent',
                'data' => [
                    'email' => $request->input('email')
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
            ], 500);

        }
    }

    /**
     * Forgot Password
     */
    public function forgotPassword(ForgotPasswordRequest $request): ResponseInterface
    {
        try {
            $response = $this->authService->handleForgotPassword($request);

            return response()->json([
                'message' => 'Forgot password successfully',
                'data' => $response
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
            ], 500);

        }
    }
}
