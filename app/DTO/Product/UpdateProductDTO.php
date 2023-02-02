<?php
declare(strict_types=1);

namespace App\DTO\Product;

use App\DTO\AbstractDTO;
use Spatie\LaravelData\Attributes\Validation\Between;
use Spatie\LaravelData\Attributes\Validation\Max;

/**
 * Class UpdateProductDTO
 * @package App\DTO\Product
 */
final class UpdateProductDTO extends AbstractDTO
{
    /**
     * @param ?string $name
     * @param ?float $price
     * @param ?string $description
     * @param ?float $available
     * @param ?float $sale
     */
    public function __construct(
        /**
         * @var ?string Product name
         */
        #[Max(255)]
        public ?string $name = null,

        /**
         * @var ?float Product price
         */
        #[Between(0.1, 100000)]
        public ?float $price = null,

        /**
         * @var ?string Product description
         */
        #[Max(10000)]
        public ?string $description = null,

        /**
         * @var ?float Product sale
         */
        #[Between(0.1, 100)]
        public ?float $available = null,

        /**
         * @var ?float Product sale
         */
        #[Between(0, 100)]
        public ?float $sale = null
    )
    {
    }
}
