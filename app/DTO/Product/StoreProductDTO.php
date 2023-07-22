<?php
declare(strict_types=1);

namespace App\DTO\Product;

use App\DTO\AbstractDTO;
use Spatie\LaravelData\Attributes\Validation\Between;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Unique;

/**
 * Class StoreProductDTO
 * @package App\DTO\Product
 */
final class StoreProductDTO extends AbstractDTO
{
    /**
     * @param string $name
     * @param ?float $price
     * @param ?string $description
     * @param ?float $available
     * @param ?float $sale
     */
    public function __construct(
        /**
         * @var string Product name
         */
        #[Max(255)]
        #[Min(5)]
        #[Unique('product', 'name')]
        public string $name,

        /**
         * @var ?float Product price
         */
        #[Between(0.1, 100000)]
        public ?float $price,

        /**
         * @var ?string Product description
         */
        #[Max(10000)]
        public ?string $description,

        /**
         * @var ?float Product sale
         */
        #[Between(0.1, 100)]
        public ?float $available = 0,

        /**
         * @var ?float Product sale
         */
        #[Between(0, 100)]
        public ?float $sale = 0
    )
    {
    }
}
