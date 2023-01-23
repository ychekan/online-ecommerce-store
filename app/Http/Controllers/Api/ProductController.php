<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTO\Product\StoreProductDTO;
use App\DTO\Product\UpdateProductDTO;
use App\Exceptions\ValidationErrorException;
use App\Http\Controllers\AppController;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\Product\CreateProductService;
use App\Services\Product\DeleteProductService;
use App\Services\Product\GetProductService;
use App\Services\Product\UpdateProductService;
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
 * Class ProductController
 * @package App\Http\Controllers\Api
 */
#[OA\Tag(name: 'App\Http\Controllers\Api\Product', description: 'Product endpoints')]
class ProductController extends AppController
{
    // todo policy

    /**
     * Display a listing of the Products.
     *
     * @param Request $request
     * @param GetProductService $getProductService
     * @return AnonymousResourceCollection
     */
    #[OA\Get(
        path: '/api/products',
//        security: [['BearerAuth' => []]],
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
    #[Get('products')]
    public function index(
        Request $request,
        GetProductService $getProductService
    ): AnonymousResourceCollection {
        return ProductResource::collection(
            $getProductService->run($request)
        );
    }

    /**
     * Store a newly created Product.
     *
     * @param StoreProductRequest $request
     * @param CreateProductService $createProductService
     * @return ProductResource
     */
    #[OA\Post(
        path: '/api/products',
//        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/StoreProductRequest')
        ),
        tags: ['Product'],
        responses: [
            new OA\Response(
                response: '201',
                description: 'Stored a newly created Product',
                content: new OA\JsonContent(ref: '#/components/schemas/ProductResource')
            ),
        ]
    )]
    #[Post('products', middleware: '')]
    public function store(
        StoreProductRequest $request,
        CreateProductService $createProductService
    ): ProductResource {
        return new ProductResource(
            $createProductService->run(StoreProductDTO::from($request->all()))
        );
    }

    /**
     * Display the specified Product by ID.
     *
     * @param Product $product
     * @return ProductResource
     */
    #[OA\Get(
        path: '/api/v1/products/{id}',
//        security: [['BearerAuth' => []]],
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

    /**
     * Update the specified Product by ID.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @param UpdateProductService $updateProductService
     * @return ProductResource
     * @throws ValidationException
     */
    #[OA\Put(
        path: '/api/v1/products/{id}',
//        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/UpdateProductRequest')
        ),
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
                description: 'Updated the specified Product by ID',
                content: new OA\JsonContent(ref: '#/components/schemas/ProductResource')
            ),
        ]
    )]
    #[Put('products/{product}')]
    public function update(
        UpdateProductRequest $request,
        Product $product,
        UpdateProductService $updateProductService
    ): ProductResource {
        return new ProductResource(
            $updateProductService->run(
                UpdateProductDTO::validate($request->all()),
                $product
            )
        );
    }

    /**
     * Remove the specified Product by ID.
     *
     * @param Product $product
     * @param DeleteProductService $deleteProductService
     * @return Response|ValidationErrorException
     * @throws ValidationErrorException
     */
    #[OA\Delete(
        path: '/api/v1/products/{id}',
//        security: [['BearerAuth' => []]],
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
                response: '204',
                description: 'Removed the specified Product by ID'
            ),
        ]
    )]
    #[Delete('products/{product}')]
    public function destroy(
        Product $product,
        DeleteProductService $deleteProductService
    ): Response|ValidationErrorException {
        if ($deleteProductService->run($product)) {
            return response()->noContent();
        }

        throw new ValidationErrorException(
            __('validation.custom.delete.cant_remove', ['attribute' => 'product'])
        );
    }
}
