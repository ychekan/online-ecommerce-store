<?php

namespace App\Http\Controllers\Api\Admin;

use App\DTO\Brand\StoreBrandDTO;
use App\DTO\Brand\UpdateBrandDTO;
use App\Exceptions\ValidationErrorException;
use App\Http\Controllers\AppController;
use App\Http\Requests\Brand\RestoreBrandRequest;
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
use Spatie\RouteAttributes\Attributes\Put;

/**
 * Class BrandController
 * @package App\Http\Controllers\Api\Admin
 */
#[OA\Tag(name: 'BrandController', description: 'Admin Brand endpoints')]
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
    #[Get('admin/brands')]
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
    #[Post('admin/brands')]
    public function store(
        StoreBrandRequest $request,
        CreateBrandService $createBrandService
    ): BrandResource {
        return new BrandResource(
            $createBrandService->run(StoreBrandDTO::from($request->all()))
        );
    }

    /**
     * Display the specified Brand by ID.
     *
     * @param Brand $brand
     * @return BrandResource
     */
    #[OA\Get(
        path: '/api/v1/admin/brands/{id}',
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
    #[Get('admin/brands/{brand}')]
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
        path: '/api/v1/admin/brands/{id}',
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
    #[Put('admin/brands/{brand}')]
    public function update(
        UpdateBrandRequest $request,
        Brand $brand,
        UpdateBrandService $updateBrandService
    ): BrandResource {
        return new BrandResource(
            $updateBrandService->run(
                UpdateBrandDTO::validate($request->all()),
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
        path: '/api/v1/admin/brands/{id}',
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
    #[Delete('admin/brands/{brand}')]
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
     * Restore the specified Brands by ID.
     *
     * @param RestoreBrandRequest $request
     * @param RestoreBrandService $restoreBrandService
     * @return AnonymousResourceCollection|ValidationErrorException
     * @throws ValidationErrorException
     */
    #[OA\Post(
        path: '/api/admin/brands/restore',
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/RestoreBrandRequest')
        ),
        tags: ['AdminBrand'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Restore brands',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/BrandResource')
                    )
                ]
            ),
        ]
    )]
    #[Post('admin/brands/restore')]
    public function restore(
        RestoreBrandRequest $request,
        RestoreBrandService $restoreBrandService
    ): AnonymousResourceCollection|ValidationErrorException
    {
        $brands = $restoreBrandService->run($request->all());
        if ($brands->isNotEmpty()) {
            return BrandResource::collection($brands);
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
        path: '/api/v1/admin/brands/{id}/force',
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
    #[Delete('admin/brands/{brand}/force')]
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
}
