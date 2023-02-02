<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\DTO\Auth\RegisterDTO;
use App\Http\Controllers\AppController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\Auth\RegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Post;

/**
 * Class RegistrationController
 * @package App\Http\Controllers\Api\Auth
 */
class RegistrationController extends AppController
{
    /**
     * @param RegisterRequest $request
     * @param RegistrationService $registrationService
     * @return UserResource|JsonResponse
     * @throws ValidationException
     */
    #[OA\Post(
        path: '/api/register',
        description: 'Registration endpoints',
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
    public function __invoke(
        RegisterRequest $request,
        RegistrationService $registrationService
    ): UserResource|JsonResponse {
        return new UserResource(
            $registrationService->run(
                RegisterDTO::validate($request->validated())
            )
        );
    }
}
