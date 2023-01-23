<?php
declare(strict_types=1);

namespace App\Services\Category;

use App\DTO\Brand\StoreBrandDTO;
use App\DTO\Category\StoreCategoryDTO;
use App\DTO\Product\StoreProductDTO;
use App\Models\Brand;
use App\Models\Category;
use App\Services\AppService;

/**
 * Class CreateCategoryService
 * @package App\Services\Category
 */
class CreateCategoryService extends AppService
{
    /**
     * @param StoreCategoryDTO $categoryDTO
     * @return Category|null
     */
    public function run(StoreCategoryDTO $categoryDTO): Category|null
    {
        return $this->createCategory($categoryDTO);
    }

    /**
     * @param StoreCategoryDTO $categoryDTO
     * @return Category|null
     */
    private function createCategory(StoreCategoryDTO $categoryDTO): Category|null
    {
        return Category::create($categoryDTO->toArray());
    }
}
