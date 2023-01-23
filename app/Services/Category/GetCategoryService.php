<?php
declare(strict_types=1);

namespace App\Services\Category;

use App\Models\Category;
use App\Services\AppService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class GetCategoryService
 * @package App\Services\Category
 */
class GetCategoryService extends AppService
{
    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function run(Request $request): LengthAwarePaginator
    {
        return $this->getCategories($request);
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    private function getCategories(Request $request): LengthAwarePaginator
    {
        return Category::filter($request->all())
            ->sort($request)
            ->paginateLimit($request);
    }
}
