<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\DTO\Product\StoreProductDTO;
use App\DTO\Product\UpdateProductDTO;
use App\Exceptions\ValidationErrorException;
use App\Http\Controllers\AppController;
use App\Http\Requests\Admin\Product\RestoreProductRequest;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\Product\CreateProductService;
use App\Services\Product\DeleteProductService;
use App\Services\Product\ForceDeleteProductService;
use App\Services\Product\GetProductService;
use App\Services\Product\RestoreProductService;
use App\Services\Product\UpdateProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Put;
use Spatie\RouteAttributes\Attributes\Where;

/**
 * Class ProductController
 * @package App\Http\Controllers\Api\Admin
 */
#[OA\Tag(name: 'ProductController', description: 'Admin product endpoints')]
#[Middleware(['auth:sanctum', 'role:admin'])]
#[Prefix('admin')]
#[Where('product', '[0-9]+')]
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
        path: '/api/admin/products',
        tags: ['AdminProduct'],
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
    ): AnonymousResourceCollection
    {
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
        path: '/api/admin/products',
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/StoreProductRequest')
        ),
        tags: ['AdminProduct'],
        responses: [
            new OA\Response(
                response: '201',
                description: 'Stored a newly created Product',
                content: new OA\JsonContent(ref: '#/components/schemas/ProductResource')
            ),
        ]
    )]
    #[Post('products')]
    public function store(
        StoreProductRequest $request,
        CreateProductService $createProductService
    ): ProductResource
    {
        return new ProductResource(
            $createProductService->run(
                StoreProductDTO::validate($request->validated())
            )
        );
    }

    /**
     * Display the specified Product by ID.
     *
     * @param Product $product
     * @return ProductResource
     */
    #[OA\Get(
        path: '/api/admin/products/{id}',
        security: [['BearerAuth' => []]],
        tags: ['AdminProduct'],
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
    #[Get('products/{product:id}')]
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
        path: '/api/admin/products/{id}',
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/UpdateProductRequest')
        ),
        tags: ['AdminProduct'],
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
    #[Put('products/{product:id}')]
    public function update(
        UpdateProductRequest $request,
        Product $product,
        UpdateProductService $updateProductService
    ): ProductResource
    {
        return new ProductResource(
            $updateProductService->run(
                UpdateProductDTO::validate($request->validated()),
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
        path: '/api/admin/products/{id}',
        security: [['BearerAuth' => []]],
        tags: ['AdminProduct'],
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
    #[Delete('products/{product:id}')]
    public function destroy(
        Product $product,
        DeleteProductService $deleteProductService
    ): Response|ValidationErrorException
    {
        if ($deleteProductService->run($product)) {
            return response()->noContent();
        }

        throw new ValidationErrorException(
            __('validation.custom.delete.cant_remove', ['attribute' => 'product'])
        );
    }

    /**
     * Restore the specified Products by ID.
     *
     * @param RestoreProductRequest $request
     * @param RestoreProductService $restoreProductService
     * @return AnonymousResourceCollection|ValidationErrorException
     * @throws ValidationErrorException
     */
    #[OA\Post(
        path: '/api/admin/products/restore',
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/RestoreProductRequest')
        ),
        tags: ['AdminProduct'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Restore products',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/ProductResource')
                    )
                ]
            ),
        ]
    )]
    #[Post('products/restore')]
    public function restore(
        RestoreProductRequest $request,
        RestoreProductService $restoreProductService
    ): AnonymousResourceCollection|ValidationErrorException
    {
        $products = $restoreProductService->run($request->validated());
        if ($products->isNotEmpty()) {
            return ProductResource::collection($products);
        }

        throw new ValidationErrorException(
            __('validation.custom.restore.cant_restore', ['attribute' => 'product'])
        );
    }

    /**
     * Remove the specified Product by ID.
     *
     * @param Product $product
     * @param ForceDeleteProductService $forceDeleteProductService
     * @return Response|ValidationErrorException
     * @throws ValidationErrorException
     */
    #[OA\Delete(
        path: '/api/admin/products/{id}/force',
        security: [['BearerAuth' => []]],
        tags: ['AdminProduct'],
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
    #[Delete('products/{product:id}/force')]
    public function force(
        Product $product,
        ForceDeleteProductService $forceDeleteProductService
    ): Response|ValidationErrorException
    {
        if ($forceDeleteProductService->run($product)) {
            return response()->noContent();
        }

        throw new ValidationErrorException(
            __('validation.custom.delete.cant_force_delete', ['attribute' => 'product'])
        );
    }

    // todo: add multiple soft delete
    // todo: add multiple force delete
    // todo: add multiple restore
}
