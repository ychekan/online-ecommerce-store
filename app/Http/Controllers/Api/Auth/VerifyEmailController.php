<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\DTO\Verify\VerifyEmailDTO;
use App\Exceptions\ValidationErrorException;
use App\Http\Controllers\AppController;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Http\Resources\SuccessResource;
use App\Services\Verify\VerifyEmailService;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Post;

/**
 * Class VerifyEmailController
 * @package App\Http\Controllers\Api
 */
#[OA\Tag(name: 'VerifyEmail', description: 'Verify email endpoints')]
class VerifyEmailController extends AppController
{
    /**
     * Verify email.
     *
     * @param VerifyEmailRequest $request
     * @param VerifyEmailService $verifyEmailService
     * @return SuccessResource|ValidationErrorException
     * @throws ValidationException
     */
    #[OA\Post(
        path: '/api/verify-email',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/VerifyEmailRequest')
        ),
        tags: ['VerifyEmail'],
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
    #[Post('verify-email', name: 'verify-email')]
    public function __invoke(
        VerifyEmailRequest $request,
        VerifyEmailService $verifyEmailService
    ): SuccessResource|ValidationErrorException
    {
        $result = $verifyEmailService->run(
            VerifyEmailDTO::validate(
                $request->validated()
            )
        );

        if (!$result) {
            return new ValidationErrorException(__('auth.verify_email.failed'));
        }
        return new SuccessResource(__('success.verify_email_success'));
    }
}
