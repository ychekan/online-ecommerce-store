<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppController;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\Product\GetProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Where;

/**
 * Class ProductController
 * @package App\Http\Controllers\Api
 */
#[OA\Tag(name: 'Product', description: 'Product endpoints')]
#[Where('product', '[a-z0-1\-]+')]
class ProductController extends AppController
{
    /**
     * Display a listing of the Products.
     *
     * @param Request $request
     * @param GetProductService $getProductService
     * @return AnonymousResourceCollection
     */
    #[OA\Get(
        path: '/api/products',
        tags: ['Product'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Display a listing of the Products',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/ProductResource')
                    )
                ]
            )
        ]
    )]
    #[Get('products', middleware: 'auth:sanctum')]
    public function index(
        Request $request,
        GetProductService $getProductService
    ): AnonymousResourceCollection {
        return ProductResource::collection(
            $getProductService->run($request)
        );
    }

    /**
     * Display the specified Product by ID.
     *
     * @param Product $product
     * @return ProductResource
     */
    #[OA\Get(
        path: '/api/products/{id}',
        security: [['BearerAuth' => []]],
        tags: ['Product'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'Product ID',
                in: 'path',
                required: true,
            ),
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Display the specified Product by ID',
                content: new OA\JsonContent(ref: '#/components/schemas/ProductResource')
            ),
        ]
    )]
    #[Get('products/{product}')]
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }
}
