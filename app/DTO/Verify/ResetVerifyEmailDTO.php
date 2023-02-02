<?php
declare(strict_types=1);

namespace App\DTO\Verify;

use App\DTO\AbstractDTO;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;

/**
 * Class ResetVerifyEmailDTO
 * @package App\DTO\Verify
 */
final class ResetVerifyEmailDTO extends AbstractDTO
{
    /**
     * @param string $email
     */
    public function __construct(
        /**
         * @var string User email
         */
        #[Max(100)]
        #[email]
        #[Exists('users', 'email')]
        public string $email,
    )
    {
    }
}
