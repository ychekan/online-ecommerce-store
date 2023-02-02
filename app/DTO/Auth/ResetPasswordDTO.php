<?php
declare(strict_types=1);

namespace App\DTO\Auth;

use App\DTO\AbstractDTO;
use Spatie\LaravelData\Attributes\Validation\Max;

/**
 * Class ResetPasswordDTO
 * @package App\DTO\Auth
 */
final class ResetPasswordDTO extends AbstractDTO
{
    // todo add validation rules
    /**
     * @param string $password
     * @param string $password_confirmation
     * @param string $token
     */
    public function __construct(

        /**
         * @var string User password
         */
        #[Max(50)]
        public string $password,

        /**
         * @var string User password confirmation
         */
        #[Max(50)]
        public string $password_confirmation,

        /**
         * @var string User token
         */
        #[Max(50)]
        public string $token,
    )
    {
    }
}
