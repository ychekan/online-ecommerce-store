<?php
declare(strict_types=1);

namespace App\Services\Category;

use App\Models\Category;
use App\Services\AppService;

/**
 * Class UpdateCategoryService
 * @package App\Services\Category
 */
class UpdateCategoryService extends AppService
{
    /**
     * @param array $updateDTO
     * @param Category $category
     * @return Category
     */
    public function run(array $updateDTO, Category $category): Category
    {
        return $this->update($updateDTO, $category);
    }

    /**
     * @param array $updateDTO
     * @param Category $category
     * @return Category
     */
    private function update(array $updateDTO, Category $category): Category
    {
        $category
            ->fill($updateDTO)
            ->save();
        return $category->refresh();
    }
}
