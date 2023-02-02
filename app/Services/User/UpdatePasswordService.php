<?php
declare(strict_types=1);

namespace App\Services\User;

use App\Exceptions\ValidationErrorException;
use App\Models\User;
use App\Notifications\PasswordIsResetNotification;
use App\Services\AppService;

/**
 * Class UpdatePasswordService
 * @package App\Services\User
 */
class UpdatePasswordService extends AppService
{
    /**
     * @param array $dataDTO
     * @param User|null $user
     * @return User
     * @throws ValidationErrorException
     */
    public function run(array $dataDTO, User|null $user): User
    {
        return $this->updatePassword($dataDTO, $user);
    }

    /**
     * @param array $dataDTO
     * @param User|null $user
     * @return User
     * @throws ValidationErrorException
     */
    private function updatePassword(array $dataDTO, User|null $user = null): User
    {
        if (!$user) {
            throw new ValidationErrorException(__('auth.reset_password.user_not_found'));
        }

        $user->fill([
            'password' => $dataDTO['password']
        ])->save();

        $user->notify(new PasswordIsResetNotification());

        return $user->refresh();
    }


}
