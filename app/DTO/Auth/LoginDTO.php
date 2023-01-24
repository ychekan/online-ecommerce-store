<?php
declare(strict_types=1);

namespace App\DTO\Auth;

use App\DTO\AbstractDTO;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Unique;

/**
 * Class LoginDTO
 * @package App\DTO\Auth
 */
final class LoginDTO extends AbstractDTO
{
    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(
        /**
         * @var string User email
         */
        #[Max(100)]
        #[email]
        #[Unique('users', 'email')]
        public string $email,

        /**
         * @var string User password
         */
        #[Max(255)]
        public string $password,
    )
    {
    }
}
