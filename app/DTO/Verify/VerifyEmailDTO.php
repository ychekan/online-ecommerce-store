<?php
declare(strict_types=1);

namespace App\DTO\Verify;

use App\DTO\AbstractDTO;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;

/**
 * Class VerifyEmailDTO
 * @package App\DTO\Auth
 */
final class VerifyEmailDTO extends AbstractDTO
{

    /**
     * @param int $id
     * @param string $token
     */
    public function __construct(
        /**
         * @var int $id
         */
        #[Required]
        #[Numeric]
        #[Exists('users', 'id')]
        public int $id,

        /**
         * @var string $token
         */
        #[Required]
        #[Exists('confirm_email_tokens', 'token')]
        public string $token,
    )
    {
    }
}
