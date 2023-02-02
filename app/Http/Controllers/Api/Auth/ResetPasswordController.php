<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\DTO\Auth\ResetPasswordDTO;
use App\Exceptions\ValidationErrorException;
use App\Http\Controllers\AppController;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\SuccessResource;
use App\Services\Auth\ResetPasswordService;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Post;

/**
 * Class ResetPasswordController
 * @package App\Http\Controllers\Api\Auth
 */
class ResetPasswordController extends AppController
{
    /**
     * @param ResetPasswordRequest $request
     * @param ResetPasswordService $resetPasswordService
     * @return SuccessResource
     * @throws ValidationErrorException
     * @throws ValidationException
     */
    #[OA\Post(
        path: '/api/reset-password',
        description: 'Reset Password endpoints',
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/ResetPasswordRequest')
        ),
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Reset password',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/SuccessResource')
                    )
                ]
            ),
        ]
    )]
    #[Post('reset-password')]
    public function __invoke(
        ResetPasswordRequest $request,
        ResetPasswordService $resetPasswordService
    ): SuccessResource
    {
        $resetPasswordService->run(
            ResetPasswordDTO::validate($request->validated())
        );
        return new SuccessResource(__('success.password_will_be_reset_success'));
    }
}
