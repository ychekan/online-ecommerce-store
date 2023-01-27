<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppController;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Services\Category\GetCategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;
use Spatie\RouteAttributes\Attributes\Get;

/**
 * Class CategoryController
 * @package App\Http\Controllers\Api
 */
#[OA\Tag(name: 'CategoryController', description: 'Category endpoints')]
class CategoryController extends AppController
{
    /**
     * Display a listing of the Categories.
     *
     * @param Request $request
     * @param GetCategoryService $getCategoryService
     * @return AnonymousResourceCollection
     */
    #[OA\Get(
        path: '/api/categories',
        tags: ['Category'],
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
    #[Get('categories')]
    public function index(
        Request $request,
        GetCategoryService $getCategoryService
    ): AnonymousResourceCollection {
        return CategoryResource::collection(
            $getCategoryService->run($request)
        );
    }

    /**
     * Display the specified Category by ID.
     *
     * @param Category $category
     * @return CategoryResource
     */
    #[OA\Get(
        path: '/api/v1/categories/{id}',
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
    #[Get('categories/{category}')]
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }
}
