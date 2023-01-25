<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\Models\Product;
use App\Services\AppService;

/**
 * Class ForceDeleteProductService
 * @package App\Services\Product
 */
class ForceDeleteProductService extends AppService
{
    /**
     * @param Product $product
     * @return bool
     */
    public function run(Product $product): bool
    {
        return $this->forceDeleteProduct($product);
    }

    /**
     * @param Product $product
     * @return bool
     */
    private function forceDeleteProduct(Product $product): bool
    {
        return $product->forceDelete();
    }
}
