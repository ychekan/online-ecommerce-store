<?php
declare(strict_types=1);

namespace App\Services\Brand;

use App\DTO\Brand\StoreBrandDTO;
use App\DTO\Product\StoreProductDTO;
use App\Models\Brand;
use App\Services\AppService;

/**
 * Class CreateBrandService
 * @package App\Services\Brand
 */
class CreateBrandService extends AppService
{
    /**
     * @param StoreBrandDTO $brandDTO
     * @return Brand|null
     */
    public function run(StoreBrandDTO $brandDTO): Brand|null
    {
        return $this->createBrand($brandDTO);
    }

    /**
     * @param StoreBrandDTO $brandDTO
     * @return Brand|null
     */
    private function createBrand(StoreBrandDTO $brandDTO): Brand|null
    {
        return Brand::create($brandDTO->toArray());
    }
}
