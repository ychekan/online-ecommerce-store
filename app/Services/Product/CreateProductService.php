<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\Models\Product;
use App\Services\AppService;

/**
 * Class CreateProductService
 * @package App\Services\Product
 */
class CreateProductService extends AppService
{
    /**
     * @param array $productDTO
     * @return Product|null
     */
    public function run(array $productDTO): Product|null
    {
        return $this->createProduct($productDTO);
    }

    /**
     * @param array $productDTO
     * @return Product|null
     */
    private function createProduct(array $productDTO): Product|null
    {
        return Product::create($productDTO);
    }
}
