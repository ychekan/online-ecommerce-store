<?php
declare(strict_types=1);

namespace App\DTO\Brand;

use App\DTO\AbstractDTO;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Unique;

/**
 * Class UpdateBrandDTO
 * @package App\DTO\Brand
 */
final class UpdateBrandDTO extends AbstractDTO
{
    /**
     * @param ?string $name
     */
    public function __construct(
        /**
         * @var ?string Brand name
         */
        #[Max(255)]
        #[Min(2)]
        #[Unique('categories', 'name')]
        public ?string $name = null,
    )
    {
    }
}
