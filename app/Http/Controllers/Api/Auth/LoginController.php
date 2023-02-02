<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\DTO\Auth\LoginDTO;
use App\Exceptions\ValidationErrorException;
use App\Http\Controllers\AppController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\ProfileResource;
use App\Services\Auth\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Post;

/**
 * Class LoginController
 * @package App\Http\Controllers\Api\Auth
 */
#[OA\Tag(name: 'LoginController', description: 'Login endpoints')]
class LoginController extends AppController
{
    /**
     * Login user.
     *
     * @param LoginRequest $request
     * @param LoginService $loginService
     * @return SuccessResource|JsonResponse
     * @throws ValidationErrorException
     * @throws ValidationException
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
    public function __invoke(
        LoginRequest $request,
        LoginService $loginService
    ): ProfileResource|JsonResponse
    {
        if ($user = $loginService->run(LoginDTO::validate($request->validated()), $request)) {
            return new ProfileResource($user);
        }
        throw new ValidationErrorException(__('auth.not_valid_credentials'));
    }
}
