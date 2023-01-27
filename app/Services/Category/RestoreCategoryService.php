<?php
declare(strict_types=1);

namespace App\Services\Category;

use App\Models\Category;
use App\Services\AppService;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RestoreCategoryService
 * @package App\Services\Category
 */
class RestoreCategoryService extends AppService
{
    /**
     * @param array $ids
     * @return Collection
     */
    public function run(array $ids): Collection
    {
        return $this->restoreCategories($ids);
    }

    /**
     * @param array $ids
     * @return Collection
     */
    private function restoreCategories(array $ids): Collection
    {
        $categories = Category::onlyTrashed()
            ->whereIn('id', $ids)->get();

        $categories->map(fn ($product) => $product->restore());

        return $categories;
    }
}
