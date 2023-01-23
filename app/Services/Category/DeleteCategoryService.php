<?php
declare(strict_types=1);

namespace App\Services\Category;

use App\Models\Category;
use App\Services\AppService;

/**
 * Class DeleteCategoryService
 * @package App\Services\Category
 */
class DeleteCategoryService extends AppService
{
    /**
     * @param Category $category
     * @return bool
     */
    public function run(Category $category): bool
    {
        return $this->removeCategory($category);
    }

    /**
     * @param Category $category
     * @return bool
     */
    private function removeCategory(Category $category): bool
    {
        return $category->delete();
    }
}
