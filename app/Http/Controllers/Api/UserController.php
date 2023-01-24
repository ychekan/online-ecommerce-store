<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppController;
use App\Http\Resources\User\UserResource;
use Spatie\RouteAttributes\Attributes\Get;
use OpenApi\Attributes as OA;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
#[OA\Tag(name: 'UserController', description: 'User endpoints')]
class UserController extends AppController
{
    #[OA\Get(
        path: '/api/profile',
        security: [['BearerAuth' => []]],
        tags: ['User'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Display the user profile',
                content: new OA\JsonContent(ref: '#/components/schemas/UserResource')
            ),
        ]
    )]
    #[Get('profile', middleware: ['auth:sanctum'])]
    public function profile(): UserResource
    {
        // todo: Add phone, address
        $user = auth()->user();

        return new UserResource($user);
    }

    // todo: update profile
    // todo: update password
    // todo: update email
    // todo: update phone
    // todo: update personal data
}
