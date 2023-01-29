<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\AppController;
use App\Http\Resources\Auth\RefreshTokenResource;
use App\Services\Auth\RefreshTokenService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Post;

/**
 * Class RefreshTokenController
 * @package App\Http\Controllers\Api\Auth
 */
class RefreshTokenController extends AppController
{
    /**
     * Refresh token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    #[OA\Post(
        path: '/api/refresh',
        security: [['BearerAuth' => []]],
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Logout user',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/RefreshTokenResource')
                    )
                ]
            ),
        ]
    )]
    #[Post('refresh')]
    public function __inoke(
        Request $request,
        RefreshTokenService $refreshTokenService
    ): RefreshTokenResource
    {
        $response = $refreshTokenService->run($request);

        return new RefreshTokenResource($response);
    }
}
