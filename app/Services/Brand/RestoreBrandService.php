<?php
declare(strict_types=1);

namespace App\Services\Brand;

use App\Models\Brand;
use App\Services\AppService;

/**
 * Class RestoreBrandService
 * @package App\Services\Brand
 */
class RestoreBrandService extends AppService
{
    /**
     * @param Brand $brand
     * @return Brand
     */
    public function run(Brand $brand): Brand
    {
        return $this->restoreBrand($brand);
    }

    /**
     * @param Brand $brand
     * @return Brand
     */
    private function restoreBrand(Brand $brand): Brand
    {
        $brand->restore();

        return $brand->refresh();
    }
}
