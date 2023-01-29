<?php
declare(strict_types=1);

namespace App\DTO\Auth;

use App\DTO\AbstractDTO;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;

/**
 * Class LoginDTO
 * @package App\DTO\Auth
 */
final class LoginDTO extends AbstractDTO
{
    /**
     * @param string $email
     * @param string $password
     * @param bool $remember_me
     */
    public function __construct(
        /**
         * @var string User email
         */
        #[Max(100)]
        #[email]
        public string $email,

        /**
         * @var string User password
         */
        #[Max(50)]
        public string $password,
    )
    {
    }
}
