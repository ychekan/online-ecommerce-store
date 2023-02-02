<?php
declare(strict_types=1);

namespace App\Services\Category;

use App\Models\Category;
use App\Services\AppService;

/**
 * Class CreateCategoryService
 * @package App\Services\Category
 */
class CreateCategoryService extends AppService
{
    /**
     * @param array $categoryDTO
     * @return Category|null
     */
    public function run(array $categoryDTO): Category|null
    {
        return $this->createCategory($categoryDTO);
    }

    /**
     * @param array $categoryDTO
     * @return Category|null
     */
    private function createCategory(array $categoryDTO): Category|null
    {
        return Category::create($categoryDTO);
    }
}
