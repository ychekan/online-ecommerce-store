<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\AppController;
use App\Http\Resources\SuccessResource;
use App\Services\Auth\LogoutService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Post;

/**
 * Class LogoutController
 * @package App\Http\Controllers\Api\Auth
 */
class LogoutController extends AppController
{
    /**
     * @param Request $request
     * @param LogoutService $logoutService
     * @return SuccessResource
     * @throws UnauthorizedException
     */
    #[OA\Post(
        path: '/api/logout',
        description: 'Logout endpoints',
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
    #[Post('logout', middleware: ['auth:sanctum'])]
    public function __invoke(
        Request $request,
        LogoutService $logoutService
    ): SuccessResource
    {
        $logoutService->run($request->user());

        return new SuccessResource(__('success.logout'));
    }
}
