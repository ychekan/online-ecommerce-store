<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\Models\Product;
use App\Services\AppService;

/**
 * Class UpdateProductService
 * @package App\Services\Product
 */
class UpdateProductService extends AppService
{
    /**
     * @param array $updateDTO
     * @param Product $product
     * @return Product
     */
    public function run(array $updateDTO, Product $product): Product
    {
        return $this->updateProduct($updateDTO, $product);
    }

    /**
     * @param array $updateDTO
     * @param Product $product
     * @return Product
     */
    private function updateProduct(array $updateDTO, Product $product): Product
    {
        $product
            ->fill($updateDTO)
            ->save();
        return $product->refresh();
    }
}
