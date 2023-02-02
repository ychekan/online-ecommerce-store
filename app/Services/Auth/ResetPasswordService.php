<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\Exceptions\ValidationErrorException;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\AppService;
use App\Services\User\UpdatePasswordService;
use Carbon\Carbon;

/**
 * Class ResetPasswordService
 * @package App\Services\Auth
 */
class ResetPasswordService extends AppService
{
    public function __construct(private readonly UpdatePasswordService $updatePasswordService)
    {
    }

    /**
     * @param array $resetPasswordDTO
     * @return void
     * @throws ValidationErrorException
     */
    public function run(array $resetPasswordDTO): void
    {
        $this->resetPassword($resetPasswordDTO);
    }

    /**
     * @param array $resetPasswordDTO
     * @return void
     * @throws ValidationErrorException
     */
    private function resetPassword(array $resetPasswordDTO): void
    {
        $passwordReset = PasswordReset::query()
            ->where('token', $resetPasswordDTO['token'])
            ->first();

        if (!$passwordReset) {
            throw new ValidationErrorException(__('auth.reset_password.invalid_token'));
        }

        if ($passwordReset->created_at->gt(Carbon::now())) {
            throw new ValidationErrorException(__('auth.reset_password.expired_token'));
        }

        $user = User::findByEmail($passwordReset->email);

        $this->updatePasswordService->run($resetPasswordDTO, $user);
    }
}
