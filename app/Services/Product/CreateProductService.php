<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\DTO\Product\StoreProductDTO;
use App\Models\Product;
use App\Services\AppService;

/**
 * Class CreateProductService
 * @package App\Services\Product
 */
class CreateProductService extends AppService
{
    /**
     * @param StoreProductDTO $productDTO
     * @return Product|null
     */
    public function run(StoreProductDTO $productDTO): Product|null
    {
        return $this->createProduct($productDTO);
    }

    /**
     * @param StoreProductDTO $productDTO
     * @return Product|null
     */
    private function createProduct(StoreProductDTO $productDTO): Product|null
    {
        return Product::create($productDTO->toArray());
    }
}
