<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\DTO\Auth\ForgotPasswordDTO;
use App\Exceptions\ValidationErrorException;
use App\Http\Controllers\AppController;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Resources\SuccessResource;
use App\Services\Auth\ForgotPasswordService;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Post;

/**
 * Class ForgotPasswordController
 * @package App\Http\Controllers\Api\Auth
 */
class ForgotPasswordController extends AppController
{
    /**
     * @param ForgotPasswordRequest $request
     * @param ForgotPasswordService $forgotPasswordService
     * @return SuccessResource
     * @throws ValidationErrorException
     * @throws ValidationException
     */
    #[OA\Post(
        path: '/api/forgot-password',
        description: 'Forgot Password endpoints',
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/ForgotPasswordRequest')
        ),
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Forgot password',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/SuccessResource')
                    )
                ]
            ),
        ]
    )]
    #[Post('forgot-password')]
    public function __invoke(
        ForgotPasswordRequest $request,
        ForgotPasswordService $forgotPasswordService
    ): SuccessResource {
        $forgotPasswordDTO = ForgotPasswordDTO::validate($request->only('email'));

        $forgotPasswordService->run($forgotPasswordDTO['email']);

        return new SuccessResource(__('success.reset_password_success'));
    }
}
