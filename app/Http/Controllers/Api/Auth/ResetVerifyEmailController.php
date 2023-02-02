<?php

namespace App\Http\Controllers\Api\Auth;

use App\DTO\Verify\ResetVerifyEmailDTO;
use App\Exceptions\ValidationErrorException;
use App\Http\Controllers\AppController;
use App\Http\Requests\Auth\ResetVerifyEmailRequest;
use App\Http\Resources\SuccessResource;
use App\Services\Auth\ResetVerifyEmailService;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Post;

/**
 * Class ResetVerifyEmailController
 * @package App\Http\Controllers\Api
 */
#[OA\Tag(name: 'ResetVerifyEmail', description: 'Reset verify email endpoints')]
class ResetVerifyEmailController extends AppController
{
    /**
     * @param ResetVerifyEmailRequest $request
     * @param ResetVerifyEmailService $verifyEmailService
     * @return SuccessResource
     * @throws ValidationErrorException
     * @throws \Illuminate\Validation\ValidationException
     */
    #[OA\Post(
        path: '/api/reset-verify-email',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/ResetVerifyEmailRequest')
        ),
        tags: ['ResetVerifyEmail'],
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
        ]
    )]
    #[Post('reset-verify-email')]
    public function __invoke(
        ResetVerifyEmailRequest $request,
        ResetVerifyEmailService $verifyEmailService
    ): SuccessResource
    {
        $verifyEmailService->run(
            ResetVerifyEmailDTO::validate(
                $request->validated()
            )
        );
        return new SuccessResource(__('success.reset_password_success'));
    }
}
