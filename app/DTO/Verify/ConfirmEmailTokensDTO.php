<?php
declare(strict_types=1);

namespace App\DTO\Verify;

use App\DTO\AbstractDTO;
use Spatie\LaravelData\Attributes\Validation\Exists;

/**
 * Class ConfirmEmailTokensDTO
 * @package App\DTO\Verify
 */
final class ConfirmEmailTokensDTO extends AbstractDTO
{
    /**
     * @param string $token
     * @param int $user_id
     */
    public function __construct(
        /**
         * @var int $user_id
         */
        #[Exists('users', 'id')]
        public int $user_id,

        /**
         * @var string $token
         */
        public string $token,
    ) {
    }

}
