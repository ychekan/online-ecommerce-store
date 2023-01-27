<?php
declare(strict_types=1);

namespace App\Services\Brand;

use App\Models\Brand;
use App\Services\AppService;

/**
 * Class ForceDeleteBrandService
 * @package App\Services\Brand
 */
class ForceDeleteBrandService extends AppService
{
    /**
     * @param Brand $brand
     * @return bool
     */
    public function run(Brand $brand): bool
    {
        return $this->forceDeleteBrand($brand);
    }

    /**
     * @param Brand $brand
     * @return bool
     */
    private function forceDeleteBrand(Brand $brand): bool
    {
        return $brand->forceDelete();
    }
}
