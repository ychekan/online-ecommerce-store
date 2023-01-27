<?php

namespace App\Http\Controllers\Api\Admin;

use App\DTO\Category\StoreCategoryDTO;
use App\DTO\Category\UpdateCategoryDTO;
use App\Exceptions\ValidationErrorException;
use App\Http\Controllers\AppController;
use App\Http\Requests\Category\RestoreCategoryRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Services\Category\CreateCategoryService;
use App\Services\Category\DeleteCategoryService;
use App\Services\Category\ForceDeleteCategoryService;
use App\Services\Category\GetCategoryService;
use App\Services\Category\RestoreCategoryService;
use App\Services\Category\UpdateCategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Put;
use OpenApi\Attributes as OA;

/**
 * Class CategoryController
 * @package App\Http\Controllers\Api\Admin
 */
#[OA\Tag(name: 'CategoryController', description: 'Admin Category endpoints')]
class CategoryController extends AppController
{
    // todo policy
    // todo manual testing

    /**
     * Display a listing of the Categories.
     *
     * @param Request $request
     * @param GetCategoryService $getCategoryService
     * @return AnonymousResourceCollection
     */
    #[OA\Get(
        path: '/api/admin/categories',
        tags: ['AdminCategory'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Display a listing of the Categories',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/CategoryResource')
                    )
                ]
            )
        ]
    )]
    #[Get('admin/categories', middleware: 'auth:sanctum')]
    public function index(
        Request $request,
        GetCategoryService $getCategoryService
    ): AnonymousResourceCollection {
        return CategoryResource::collection(
            $getCategoryService->run($request)
        );
    }

    /**
     * Store a newly created Category.
     *
     * @param StoreCategoryRequest $request
     * @param CreateCategoryService $createCategoryService
     * @return CategoryResource
     */
    #[OA\Post(
        path: '/api/admin/categories',
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/StoreCategoryRequest')
        ),
        tags: ['Category'],
        responses: [
            new OA\Response(
                response: '201',
                description: 'Stored a newly created Category',
                content: new OA\JsonContent(ref: '#/components/schemas/CategoryResource')
            ),
        ]
    )]
    #[Post('admin/categories', middleware: 'auth:sanctum')]
    public function store(
        StoreCategoryRequest $request,
        CreateCategoryService $createCategoryService
    ): CategoryResource {
        return new CategoryResource(
            $createCategoryService->run(StoreCategoryDTO::from($request->all()))
        );
    }

    /**
     * Display the specified Category by ID.
     *
     * @param Category $category
     * @return CategoryResource
     */
    #[OA\Get(
        path: '/api/v1/admin/categories/{id}',
        security: [['BearerAuth' => []]],
        tags: ['Category'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'Category ID',
                in: 'path',
                required: true,
            ),
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Display the specified Category by ID',
                content: new OA\JsonContent(ref: '#/components/schemas/CategoryResource')
            ),
        ]
    )]
    #[Get('admin/categories/{category}', middleware: 'auth:sanctum')]
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified Category by ID.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @param UpdateCategoryService $updateCategoryService
     * @return CategoryResource
     * @throws ValidationException
     */
    #[OA\Put(
        path: '/api/v1/admin/categories/{id}',
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/UpdateCategoryRequest')
        ),
        tags: ['Category'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'Category ID',
                in: 'path',
                required: true,
            ),
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Updated the specified Category by ID',
                content: new OA\JsonContent(ref: '#/components/schemas/CategoryResource')
            ),
        ]
    )]
    #[Put('admin/categories/{category}', middleware: 'auth:sanctum')]
    public function update(
        UpdateCategoryRequest $request,
        Category $category,
        UpdateCategoryService $updateCategoryService
    ): CategoryResource {
        return new CategoryResource(
            $updateCategoryService->run(
                UpdateCategoryDTO::validate($request->all()),
                $category
            )
        );
    }

    /**
     * Remove the specified Category by ID.
     *
     * @param Category $category
     * @param DeleteCategoryService $deleteCategoryService
     * @return Response|ValidationErrorException
     * @throws ValidationErrorException
     */
    #[OA\Delete(
        path: '/api/v1/admin/categories/{id}',
        security: [['BearerAuth' => []]],
        tags: ['Category'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'Category ID',
                in: 'path',
                required: true,
            ),
        ],
        responses: [
            new OA\Response(
                response: '204',
                description: 'Removed the specified Category by ID'
            ),
        ]
    )]
    #[Delete('admin/categories/{category}', middleware: 'auth:sanctum')]
    public function destroy(
        Category $category,
        DeleteCategoryService $deleteCategoryService
    ): Response|ValidationErrorException {
        if ($deleteCategoryService->run($category)) {
            return response()->noContent();
        }

        throw new ValidationErrorException(
            __('validation.custom.delete.cant_remove', ['attribute' => 'category'])
        );
    }

    /**
     * Restore the specified Categories by ID.
     *
     * @param RestoreCategoryRequest $request
     * @param RestoreCategoryService $restoreProductService
     * @return AnonymousResourceCollection|ValidationErrorException
     * @throws ValidationErrorException
     */
    #[OA\Post(
        path: '/api/admin/categories/restore',
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(ref: '#/components/schemas/RestoreCategoryRequest')
        ),
        tags: ['AdminCategory'],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Restore categories',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/CategoryResource')
                    )
                ]
            ),
        ]
    )]
    #[Post('admin/products/restore')]
    public function restore(
        RestoreCategoryRequest $request,
        RestoreCategoryService $restoreProductService
    ): AnonymousResourceCollection|ValidationErrorException
    {
        $products = $restoreProductService->run($request->all());
        if ($products->isNotEmpty()) {
            return CategoryResource::collection($products);
        }

        throw new ValidationErrorException(
            __('validation.custom.restore.cant_restore', ['attribute' => 'category'])
        );
    }

    /**
     * Remove the specified Product by ID.
     *
     * @param Category $category
     * @param ForceDeleteCategoryService $forceDeleteCategoryService
     * @return Response|ValidationErrorException
     * @throws ValidationErrorException
     */
    #[OA\Delete(
        path: '/api/v1/admin/categories/{id}/force',
        security: [['BearerAuth' => []]],
        tags: ['AdminCategory'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'Category ID',
                in: 'path',
                required: true,
            ),
        ],
        responses: [
            new OA\Response(
                response: '204',
                description: 'Removed the specified Category by ID'
            ),
        ]
    )]
    #[Delete('admin/categories/{product}/force')]
    public function force(
        Category $category,
        ForceDeleteCategoryService $forceDeleteCategoryService
    ): Response|ValidationErrorException
    {
        if ($forceDeleteCategoryService->run($category)) {
            return response()->noContent();
        }

        throw new ValidationErrorException(
            __('validation.custom.delete.cant_force_delete', ['attribute' => 'category'])
        );
    }
}
