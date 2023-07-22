<?php
declare(strict_types=1);

namespace App\DTO\Brand;

use App\DTO\AbstractDTO;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Unique;

/**
 * Class StoreBrandDTO
 * @package App\DTO\Brand
 */
final class StoreBrandDTO extends AbstractDTO
{
    /**
     * @param string $name
     */
    public function __construct(
        /**
         * @var string Brand name
         */
        #[Max(255)]
        #[Min(2)]
        #[Unique('brands', 'name')]
        public string $name,
    )
    {
    }
}
