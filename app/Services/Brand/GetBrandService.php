<?php
declare(strict_types=1);

namespace App\Services\Brand;

use App\Models\Brand;
use App\Services\AppService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class GetBrandService
 * @package App\Services\Brand
 */
class GetBrandService extends AppService
{
    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function run(Request $request): LengthAwarePaginator
    {
        return $this->getBrands($request);
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    private function getBrands(Request $request): LengthAwarePaginator
    {
        return Brand::filter($request->all())
            ->sort($request)
            ->paginateLimit($request);
    }
}
