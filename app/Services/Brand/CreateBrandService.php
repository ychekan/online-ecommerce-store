<?php
declare(strict_types=1);

namespace App\Services\Brand;

use App\Models\Brand;
use App\Services\AppService;

/**
 * Class CreateBrandService
 * @package App\Services\Brand
 */
class CreateBrandService extends AppService
{
    /**
     * @param array $brandDTO
     * @return Brand|null
     */
    public function run(array $brandDTO): Brand|null
    {
        return $this->createBrand($brandDTO);
    }

    /**
     * @param array $brandDTO
     * @return Brand|null
     */
    private function createBrand(array $brandDTO): Brand|null
    {
        return Brand::create($brandDTO);
    }
}
