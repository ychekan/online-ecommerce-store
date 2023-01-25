<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\Models\Product;
use App\Services\AppService;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RestoreProductService
 * @package App\Services\Product
 */
class RestoreProductService extends AppService
{
    /**
     * @param array $ids
     * @return Collection
     */
    public function run(array $ids): Collection
    {
        return $this->restoreProducts($ids);
    }

    /**
     * @param array $ids
     * @return Collection
     */
    private function restoreProducts(array $ids): Collection
    {
        $products = Product::onlyTrashed()
            ->whereIn('id', $ids)->get();

        $products->map(fn ($product) => $product->restore());

        return $products;
    }
}
