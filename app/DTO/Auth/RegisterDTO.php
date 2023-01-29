<?php
declare(strict_types=1);

namespace App\DTO\Auth;

use App\DTO\AbstractDTO;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Unique;

/**
 * Class RegisterDTO
 * @package App\DTO\Auth
 */
final class RegisterDTO extends AbstractDTO
{
    /**
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string $password
     */
    public function __construct(
        /**
         * @var string User first name
         */
        #[Max(50)]
        public string $first_name,

        /**
         * @var string User last name
         */
        #[Max(50)]
        public string $last_name,

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
        #[Max(50)]
        public string $password,
    )
    {
    }
}
