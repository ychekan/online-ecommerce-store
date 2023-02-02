<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\Exceptions\ValidationErrorException;
use App\Models\User;
use App\Notifications\RegisterNotification;
use App\Services\AppService;
use App\Services\Verify\ConfirmTokenService;

/**
 * Class ResetVerifyEmailService
 * @package App\Services\Auth
 */
class ResetVerifyEmailService extends AppService
{
    public function __construct(private readonly ConfirmTokenService $confirmTokenService)
    {
    }

    /**
     * @param array $dataDTO
     * @return void
     * @throws ValidationErrorException
     */
    public function run(array $dataDTO): void
    {
        $this->resetVerifyEmail($dataDTO);
    }

    /**
     * @param array $dataDTO
     * @return void
     * @throws ValidationErrorException
     */
    private function resetVerifyEmail(array $dataDTO): void
    {
        try {
            $user = User::findByEmail($dataDTO);

            // Generate token for confirm email
            $this->confirmTokenService->deleteToken($user->id);

            // Generate token for confirm email
            $this->confirmTokenService->createToken($user);

            // Send email for confirm email
            $user->notify(new RegisterNotification());
        } catch (\Exception $e) {
            throw new ValidationErrorException($e->getMessage());
        }
    }
}
