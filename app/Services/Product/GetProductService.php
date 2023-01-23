<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\Models\Product;
use App\Services\AppService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class GetProductService
 * @package App\Services\Product
 */
class GetProductService extends AppService
{
    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function run(Request $request): LengthAwarePaginator
    {
        return $this->getProducts($request);
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    private function getProducts(Request $request): LengthAwarePaginator
    {
        return Product::filter($request->all())
            ->with(['category', 'brand'])
            ->sort($request)
            ->paginateLimit($request);
    }
}
