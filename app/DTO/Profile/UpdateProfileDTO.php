<?php
declare(strict_types=1);

namespace App\DTO\Profile;

use App\DTO\AbstractDTO;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Max;

/**
 * Class UpdateProfileDTO
 * @package App\DTO\Profile
 */
final class UpdateProfileDTO extends AbstractDTO
{
    /**
     * @param ?string $first_name
     * @param ?string $last_name
     * @param ?string $email
     * @param ?string $phone
     * @param ?string $city
     * @param ?string $state
     * @param ?string $zip
     * @param ?string $country
     * @param ?string $street
     * @param ?string $apartment
     * @param ?boolean $as_delivery_address
     */
    public function __construct(
        #[Max(50)]
        public ?string $first_name = null,

        #[Max(50)]
        public ?string $last_name = null,

        #[Max(100)]
        public ?string $email = null,

        #[Max(15)]
        public ?string $phone = null,

        #[Max(30)]
        public ?string $city = null,

        #[Max(30)]
        public ?string $state = null,

        #[Max(6)]
        public ?string $zip = null,

        #[Max(30)]
        public ?string $country = null,

        #[Max(30)]
        public ?string $street = null,

        #[Max(30)]
        public ?string $apartment = null,

        #[BooleanType]
        public ?bool $as_delivery_address = null,
    )
    {
    }
}
