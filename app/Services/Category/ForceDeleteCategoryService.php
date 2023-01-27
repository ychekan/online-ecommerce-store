<?php
declare(strict_types=1);

namespace App\Services\Category;

use App\Models\Category;
use App\Services\AppService;

/**
 * Class ForceDeleteCategoryService
 * @package App\Services\Category
 */
class ForceDeleteCategoryService extends AppService
{
    /**
     * @param Category $category
     * @return bool
     */
    public function run(Category $category): bool
    {
        return $this->forceDeleteCategory($category);
    }

    /**
     * @param Category $category
     * @return bool
     */
    private function forceDeleteCategory(Category $category): bool
    {
        return $category->forceDelete();
    }
}
