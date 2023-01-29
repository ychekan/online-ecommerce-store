<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\DTO\Auth\RegisterDTO;
use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Notifications\RegisterNotification;
use App\Services\AppService;
use Illuminate\Support\Facades\Notification;

/**
 * Class RegistrationService
 * @package App\Services\User
 */
class RegistrationService extends AppService
{
    /**
     * @param array $registerDTO
     * @return User
     */
    public function run(array $registerDTO): User
    {
        return $this->register($registerDTO);
    }

    /**
     * @param array $registerDTO
     * @return User
     */
    public function register(array $registerDTO): User
    {
//        $user = User::create($registerDTO);
//
//        $user->assignRole(UserRoleEnum::USER->value);

//        Notification::send($user, new RegisterNotification($user));

        $user = User::find(11);

        $user->notify(new RegisterNotification());

        // todo: Add send email verification
        // todo: Add resend email verification

        return $user->refresh();
    }
}
