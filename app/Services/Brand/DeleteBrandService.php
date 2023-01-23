<?php
declare(strict_types=1);

namespace App\Services\Brand;

use App\Models\Brand;
use App\Services\AppService;

/**
 * Class DeleteBrandService
 * @package App\Services\Brand
 */
class DeleteBrandService extends AppService
{
    /**
     * @param Brand $brand
     * @return bool
     */
    public function run(Brand $brand): bool
    {
        return $this->removeBrand($brand);
    }

    /**
     * @param Brand $brand
     * @return bool
     */
    private function removeBrand(Brand $brand): bool
    {
        return $brand->delete();
    }
}
