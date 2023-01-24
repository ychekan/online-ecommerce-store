<?php
declare(strict_types=1);

namespace App\Services\User;

use App\DTO\Auth\RegisterDTO;
use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Services\AppService;

/**
 * Class UserService
 * @package App\Services\User
 */
class UserService extends AppService
{
    /**
     * @param RegisterDTO $registerDTO
     * @return User
     */
    public function register(RegisterDTO $registerDTO): User
    {
        $user = User::create($registerDTO->toArray());

        $user->assignRole(UserRoleEnum::USER->value);

        return $user->refresh();
    }
}
