<?php

namespace App\Http\Controllers\Api\Admin;

use App\DTO\Brand\StoreBrandDTO;
use App\DTO\Brand\UpdateBrandDTO;
use App\Exceptions\ValidationErrorException;
use App\Http\Controllers\AppController;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Http\Resources\Brand\BrandResource;
use App\Models\Brand;
use App\Services\Brand\CreateBrandService;
use App\Services\Brand\DeleteBrandService;
use App\Services\Brand\ForceDeleteBrandService;
use App\Services\Brand\GetBrandService;
use App\Services\Brand\RestoreBrandService;
use App\Services\Brand\UpdateBrandService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Put;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Where;

/**
 * Class BrandController
 * @package App\Http\Controllers\Api\Admin
 */
#[OA\Tag(name: 'AdminBrand', description: 'Admin Brand endpoints')]
#[Middleware(['auth:sanctum', 'role:admin,manager'])]
#[Prefix('admin')]
#[Where('brand', '[0-9]+')]
class BrandController extends AppController
{
    // todo policy

    /**
     * Display a listing of the Brands.
     *
     * @param Request $request
     * @param GetBrandService $getBrandService
     * @return AnonymousResourceCollection
     */
    #[OA\Get(
        path: '/api/admin/brands',
        security: [['BearerAuth' => []]],
        tags: ['AdminBrand'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Display a listing of the Brands',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/BrandResource')
                    )
                ]
            )
        ]
    )]
    #[Get('brands')]
    public function index(
        Request $request,
        GetBrandService $getBrandService
    ): AnonymousResourceCollection {
        return BrandResource::collection(
            $getBrandService->run($request)
        );
    }

    /**
     * Store a newly created Brand.
     *
     * @param StoreBrandRequest $request
     * @param CreateBrandService $createBrandService
     * @return BrandResource
     * @throws ValidationException
     */
    #[OA\Post(
        path: '/api/admin/brands',
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/StoreBrandRequest')
        ),
        tags: ['AdminBrand'],
        responses: [
            new OA\Response(
                response: '201',
                description: 'Stored a newly created Brand',
                content: new OA\JsonContent(ref: '#/components/schemas/BrandResource')
            ),
        ]
    )]
    #[Post('brands')]
    public function store(
        StoreBrandRequest $request,
        CreateBrandService $createBrandService
    ): BrandResource {
        return new BrandResource(
            $createBrandService->run(
                StoreBrandDTO::validate($request->validated())
            )
        );
    }

    /**
     * Display the specified Brand by ID.
     *
     * @param Brand $brand
     * @return BrandResource
     */
    #[OA\Get(
        path: '/api/admin/brands/{id}',
        security: [['BearerAuth' => []]],
        tags: ['AdminBrand'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'Brand ID',
                in: 'path',
                required: true,
            ),
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Display the specified Brand by ID',
                content: new OA\JsonContent(ref: '#/components/schemas/BrandResource')
            ),
        ]
    )]
    #[Get('brands/{brand:id}')]
    public function show(Brand $brand): BrandResource
    {
        return new BrandResource($brand);
    }

    /**
     * Update the specified Brand by ID.
     *
     * @param UpdateBrandRequest $request
     * @param Brand $brand
     * @param UpdateBrandService $updateBrandService
     * @return BrandResource
     * @throws ValidationException
     */
    #[OA\Put(
        path: '/api/admin/brands/{id}',
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/UpdateBrandRequest')
        ),
        tags: ['AdminBrand'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'Brand ID',
                in: 'path',
                required: true,
            ),
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Updated the specified Brand by ID',
                content: new OA\JsonContent(ref: '#/components/schemas/BrandResource')
            ),
        ]
    )]
    #[Put('brands/{brand:id}')]
    public function update(
        UpdateBrandRequest $request,
        Brand $brand,
        UpdateBrandService $updateBrandService
    ): BrandResource {
        return new BrandResource(
            $updateBrandService->run(
                UpdateBrandDTO::validate($request->validated()),
                $brand
            )
        );
    }

    /**
     * Remove the specified Brand by ID.
     *
     * @param Brand $brand
     * @param DeleteBrandService $deleteBrandService
     * @return Response|ValidationErrorException
     * @throws ValidationErrorException
     */
    #[OA\Delete(
        path: '/api/admin/brands/{id}',
        security: [['BearerAuth' => []]],
        tags: ['AdminBrand'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'Brand ID',
                in: 'path',
                required: true,
            ),
        ],
        responses: [
            new OA\Response(
                response: '204',
                description: 'Removed the specified Brand by ID'
            ),
        ]
    )]
    #[Delete('brands/{brand:id}')]
    public function destroy(
        Brand $brand,
        DeleteBrandService $deleteBrandService
    ): Response|ValidationErrorException {
        if ($deleteBrandService->run($brand)) {
            return response()->noContent();
        }

        throw new ValidationErrorException(
            __('validation.custom.delete.cant_remove', ['attribute' => 'brand'])
        );
    }

    /**
     * Restore the specified Brand by ID.
     *
     * @param Brand $brand
     * @param RestoreBrandService $restoreBrandService
     * @return BrandResource|ValidationErrorException
     * @throws ValidationErrorException
     */
    #[OA\Post(
        path: '/api/admin/brands/{id}/restore',
        security: [['BearerAuth' => []]],
        tags: ['AdminBrand'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Restore brand',
                content: [
                    new OA\Response(
                        response: '200',
                        description: 'Restore the specified Brand by ID',
                        content: new OA\JsonContent(ref: '#/components/schemas/BrandResource')
                    ),
                ]
            ),
        ]
    )]
    #[Post('brands/{brand:id}/restore')]
    public function restore(
        Brand $brand,
        RestoreBrandService $restoreBrandService
    ): BrandResource|ValidationErrorException
    {
        if ($brand = $restoreBrandService->run($brand)) {
            return new BrandResource($brand);
        }

        throw new ValidationErrorException(
            __('validation.custom.restore.cant_restore', ['attribute' => 'brand'])
        );
    }

    /**
     * Remove the specified Brand by ID.
     *
     * @param Brand $brand
     * @param ForceDeleteBrandService $forceDeleteBrandService
     * @return Response|ValidationErrorException
     * @throws ValidationErrorException
     */
    #[OA\Delete(
        path: '/api/admin/brands/{id}/force',
        security: [['BearerAuth' => []]],
        tags: ['AdminBrand'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'Brand ID',
                in: 'path',
                required: true,
            ),
        ],
        responses: [
            new OA\Response(
                response: '204',
                description: 'Removed the specified Brand by ID'
            ),
        ]
    )]
    #[Delete('brands/{brand:id}/force')]
    public function force(
        Brand $brand,
        ForceDeleteBrandService $forceDeleteBrandService
    ): Response|ValidationErrorException
    {
        if ($forceDeleteBrandService->run($brand)) {
            return response()->noContent();
        }

        throw new ValidationErrorException(
            __('validation.custom.delete.cant_force_delete', ['attribute' => 'brand'])
        );
    }

    // todo: add multiple soft delete
    // todo: add multiple force delete
    // todo: add multiple restore
}
