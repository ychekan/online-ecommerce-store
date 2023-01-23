<?php
declare(strict_types=1);

namespace App\DTO\Category;

use App\DTO\AbstractDTO;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Unique;

/**
 * Class StoreCategoryDTO
 * @package App\DTO\Category
 */
final class StoreCategoryDTO extends AbstractDTO
{
    /**
     * @param string $name
     */
    public function __construct(
        /**
         * @var string Category name
         */
        #[Max(255)]
        #[Unique('categories', 'name')]// todo check this
        public string $name,
    )
    {
    }
}
