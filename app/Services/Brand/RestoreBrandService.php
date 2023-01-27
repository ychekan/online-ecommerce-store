<?php
declare(strict_types=1);

namespace App\Services\Brand;

use App\Models\Brand;
use App\Services\AppService;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RestoreBrandService
 * @package App\Services\Brand
 */
class RestoreBrandService extends AppService
{
    /**
     * @param array $ids
     * @return Collection
     */
    public function run(array $ids): Collection
    {
        return $this->restoreBrands($ids);
    }

    /**
     * @param array $ids
     * @return Collection
     */
    private function restoreBrands(array $ids): Collection
    {
        $brands = Brand::onlyTrashed()
            ->whereIn('id', $ids)->get();

        $brands->map(fn ($brand) => $brand->restore());

        return $brands;
    }
}
