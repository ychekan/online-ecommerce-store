<?php
declare(strict_types=1);

namespace App\Services\Brand;

use App\Models\Brand;
use App\Services\AppService;

/**
 * Class UpdateBrandService
 * @package App\Services\Brand
 */
class UpdateBrandService extends AppService
{
    /**
     * @param array $updateDTO
     * @param Brand $brand
     * @return Brand
     */
    public function run(array $updateDTO, Brand $brand): Brand
    {
        return $this->update($updateDTO, $brand);
    }

    /**
     * @param array $updateDTO
     * @param Brand $brand
     * @return Brand
     */
    private function update(array $updateDTO, Brand $brand): Brand
    {
        $brand
            ->fill($updateDTO)
            ->save();
        return $brand->refresh();
    }
}
