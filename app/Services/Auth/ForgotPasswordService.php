<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\Exceptions\ValidationErrorException;
use App\Models\PasswordReset;
use App\Notifications\ResetPasswordNotification;
use App\Services\AppService;
use App\Services\User\UserByEmailService;

/**
 * Class ForgotPasswordService
 * @package App\Services\Auth
 */
class ForgotPasswordService extends AppService
{
    public function __construct(
        private readonly UserByEmailService $userByEmailService
    ) {
    }

    /**
     * @param string $email
     * @return void
     * @throws ValidationErrorException
     */
    public function run(string $email): void
    {
        $this->sendResetLinkEmail($email);
    }

    /**
     * @param string $email
     * @return void
     * @throws ValidationErrorException
     */
    private function sendResetLinkEmail(string $email): void
    {
        try {
            $user = $this->userByEmailService->run($email);

            $token = PasswordReset::generateToken($email);

            $user->notify(new ResetPasswordNotification($token->token));
        } catch (\Exception $e) {
            throw new ValidationErrorException($e->getMessage());
        }
    }
}
