<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\Models\Product;
use App\Services\AppService;

/**
 * Class DeleteProductService
 * @package App\Services\Product
 */
class DeleteProductService extends AppService
{
    /**
     * @param Product $product
     * @return bool
     */
    public function run(Product $product): bool
    {
        return $this->removeProduct($product);
    }

    /**
     * @param Product $product
     * @return bool
     */
    private function removeProduct(Product $product): bool
    {
        return $product->delete();
    }
}
