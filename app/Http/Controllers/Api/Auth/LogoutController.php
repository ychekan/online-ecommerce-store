<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\AppController;
use App\Http\Resources\SuccessResource;
use App\Services\Auth\LogoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;

/**
 * Class LogoutController
 * @package App\Http\Controllers\Api\Auth
 */
#[OA\Tag(name: 'App\Http\Controllers\Api\Auth\LogoutController', description: 'Logout endpoints')]
#[Middleware(['auth:sanctum'])]
class LogoutController extends AppController
{
    /**
     * Logout user
     *
     * @param Request $request
     * @return string[]
     * @throws UnauthorizedException
     */
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
    #[Post('logout')]
    public function __invoke(
        Request $request,
        LogoutService $logoutService
    ): SuccessResource
    {
        $logoutService->run($request);

        return [
            'message' => 'Successfully logged out',
        ];
    }
}
