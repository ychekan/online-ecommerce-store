<?php

namespace App\Http\Controllers\Api;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\Exceptions\ValidationErrorException;
use App\Http\Controllers\AppController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\Post;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'App\Http\Controllers\Api\Product', description: 'Product endpoints')]
class AuthController extends AppController
{
    /**
     * @throws ValidationErrorException
     */
    #[OA\Post(
        path: '/api/login',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/LoginRequest')
        ),
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Login user',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/SuccessResource')
                    )
                ]
            ),
            new OA\Response(
                response: '422',
                description: 'Validation error',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/ValidationErrorException')
                    )
                ]
            )
        ]
    )]
    #[Post('login')]
    public function login(LoginRequest $request): SuccessResource|JsonResponse
    {
        $credentials = LoginDTO::from($request->all())
            ->toArray();

        // todo: Add remember me
        // todo: Add validation email_verified_at
        // todo: Add service for login

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return new SuccessResource(null);
        }

        throw new ValidationErrorException(__('auth.not_valid_credentials'));
    }

    /**
     * @param RegisterRequest $request
     * @param UserService $userService
     * @return UserResource|JsonResponse
     */
    #[OA\Post(
        path: '/api/register',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/RegisterRequest')
        ),
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Register user',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/UserResource')
                    )
                ]
            ),
            new OA\Response(
                response: '422',
                description: 'Validation error',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/ValidationErrorException')
                    )
                ]
            )
        ]
    )]
    #[Post('register')]
    public function register(
        RegisterRequest $request,
        UserService $userService
    ): UserResource|JsonResponse {
        $data = RegisterDTO::from($request->all());
        $user = $userService->register($data);

        return new UserResource($user);
    }

    #[OA\Post(
        path: '/api/logout',
        security: [['BearerAuth' => []]],
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Logout user',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/SuccessResource')
                    )
                ]
            ),
        ]
    )]
    #[Post('/logout')]
    public function logout(Request $request): array
    {
        Auth::logout();

        // todo: Add device_id
        // todo: refactor logout
        // todo: Add logout all devices
        // todo: Add logout current device
        // todo: Add logout other devices
        // todo: Add logout all devices except current
        // todo: Add logout all devices except other
        // todo: Add logout all devices except current and other


        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return [
            'message' => 'Logged out'
        ];
    }

    // todo: Add send email verification
    // todo: Add resend email verification
}
