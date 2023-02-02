<?php

namespace App\Http\Controllers\Api;

use App\DTO\Profile\ProfilePasswordDTO;
use App\DTO\Profile\UpdateProfileDTO;
use App\Http\Controllers\AppController;
use App\Http\Requests\Profile\ProfilePasswordRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\User\ProfileResource;
use App\Services\User\ProfilePasswordService;
use App\Services\User\UpdateProfileService;
use Illuminate\Validation\ValidationException;
use Spatie\RouteAttributes\Attributes\Get;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Put;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Api
 */
#[OA\Tag(name: 'ProfileController', description: 'Profile endpoints')]
#[Middleware(['auth:sanctum'])]
class ProfileController extends AppController
{
    #[OA\Get(
        path: '/api/profile',
        security: [['BearerAuth' => []]],
        tags: ['Profile'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Display the user profile',
                content: new OA\JsonContent(ref: '#/components/schemas/ProfileResource')
            ),
        ]
    )]
    #[Get('profile')]
    public function profile(): ProfileResource
    {
        $user = auth()->user();

        return new ProfileResource($user);
    }


    /**
     * Update profile of the user.
     *
     * @param UpdateProfileRequest $request
     * @param UpdateProfileService $updateProfileService
     * @return ProfileResource
     * @throws ValidationException
     */
    #[OA\Put(
        path: '/api/profile',
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/UpdateProfileRequest')
        ),
        tags: ['Profile'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Update the user Profile',
                content: new OA\JsonContent(ref: '#/components/schemas/ProfileResource')
            ),
        ]
    )]
    #[Put('profile')]
    public function updateProfile(
        UpdateProfileRequest $request,
        UpdateProfileService $updateProfileService
    ): ProfileResource
    {
        return new ProfileResource(
            $updateProfileService->run(
                UpdateProfileDTO::validate($request->validated()),
            )
        );

    }

    /**
     * @param ProfilePasswordRequest $request
     * @param ProfilePasswordService $profilePasswordService
     * @return ProfileResource
     * @throws ValidationException
     */
    #[OA\Put(
        path: '/api/profile/password',
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/ProfilePasswordRequest')
        ),
        tags: ['Profile'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Update user password',
                content: new OA\JsonContent(ref: '#/components/schemas/ProfilePasswordService')
            ),
        ]
    )]
    #[Put('profile/password')]
    public function updatePassword(
        ProfilePasswordRequest $request,
        ProfilePasswordService $profilePasswordService
    ): ProfileResource
    {
        return new ProfileResource(
            $profilePasswordService->run(
                ProfilePasswordDTO::validate($request->validated()),
            )
        );
    }
}
