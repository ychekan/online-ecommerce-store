<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Notifications\RegisterNotification;
use App\Services\AppService;
use App\Services\Verify\ConfirmTokenService;
use Illuminate\Validation\ValidationException;

/**
 * Class RegistrationService
 * @package App\Services\User
 */
class RegistrationService extends AppService
{
    /**
     * RegistrationService constructor.
     */
    public function __construct(private readonly ConfirmTokenService $confirmEmailTokenService)
    {
    }

    /**
     * @param array $registerDTO
     * @return User
     * @throws ValidationException
     */
    public function run(array $registerDTO): User
    {
        return $this->register($registerDTO);
    }

    /**
     * @param array $registerDTO
     * @return User
     * @throws ValidationException
     */
    public function register(array $registerDTO): User
    {
        $user = User::create($registerDTO);

        // Assign role by default for user
        $user->assignRole(UserRoleEnum::USER->value);

        // Generate token for confirm email
        $this->confirmEmailTokenService->createToken($user);

        // Send email for confirm email
        $user->notify(new RegisterNotification());

        return $user->refresh();
    }
}
