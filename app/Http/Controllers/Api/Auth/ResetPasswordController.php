<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\DTO\Auth\ResetPasswordDTO;
use App\Http\Controllers\AppController;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\ResetPasswordService;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Post;

/**
 * Class ResetPasswordController
 * @package App\Http\Controllers\Api\Auth
 */
#[OA\Tag(name: 'App\Http\Controllers\Api\Auth\ResetPasswordController', description: 'Reset Password endpoints')]
class ResetPasswordController extends AppController
{
    /**
     * Reset password
     *
     * @return void
     */
    #[OA\Post(
        path: '/api/password/reset',
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
    #[Post('password/reset')]
    public function __invoke(
        ResetPasswordRequest $request,
        ResetPasswordService $resetPasswordService
    )
    {
        $result = $resetPasswordService->run(
            ResetPasswordDTO::validate($request->validated())
        );

        return $this->success($result);
    }
}
