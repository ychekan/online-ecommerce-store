<?php
declare(strict_types=1);

namespace App\DTO\Profile;

use App\DTO\AbstractDTO;
use Spatie\LaravelData\Attributes\Validation\Max;

/**
 * Class ProfilePasswordDTO
 * @package App\DTO\Profile
 */
final class ProfilePasswordDTO extends AbstractDTO
{

    /**
     * @param string $current_password
     * @param string $new_password
     * @param string $new_password_confirmation
     */
    public function __construct(
        /**
         * @var string
         */
        #[Max(50)]
        public string $current_password,

        /**
         * @var string
         */
        #[Max(50)]
        public string $new_password,

        /**
         * @var string
         */
        #[Max(50)]
        public string $new_password_confirmation,
    )
    {
    }
}
