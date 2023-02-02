<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppController;
use App\Http\Resources\Brand\BrandResource;
use App\Models\Brand;
use App\Services\Brand\GetBrandService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Where;

/**
 * Class BrandController
 * @package App\Http\Controllers\Api
 */
#[Where('brand', '[a-z0-1\-]+')]
class BrandController extends AppController
{
    /**
     * Display a listing of the Brands.
     *
     * @param Request $request
     * @param GetBrandService $getBrandService
     * @return AnonymousResourceCollection
     */
    #[OA\Get(
        path: '/api/brands',
        security: [['BearerAuth' => []]],
        tags: ['Brand'],
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
     * Display the specified Brand by ID.
     *
     * @param Brand $brand
     * @return BrandResource
     */
    #[OA\Get(
        path: '/api/brands/{id}',
        security: [['BearerAuth' => []]],
        tags: ['Brand'],
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
    #[Get('brands/{brand}')]
    public function show(Brand $brand): BrandResource
    {
        return new BrandResource($brand);
    }
}
