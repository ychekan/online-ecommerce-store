<?php
declare(strict_types=1);

namespace App\Services\Verify;

use App\Models\User;
use App\Notifications\WelcomeNotification;
use App\Services\AppService;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

/**
 * Class VerifyEmailService
 * @package App\Services\Verify
 */
class VerifyEmailService extends AppService
{
    protected ConfirmTokenService $confirmTokenService;

    /**
     * VerifyEmailService constructor.
     */
    public function __construct(ConfirmTokenService $confirmTokenService)
    {
        $this->confirmTokenService = $confirmTokenService;
    }

    /**
     * @param array $verifyEmailDTO
     * @return bool
     * @throws ValidationException
     */
    public function run(array $verifyEmailDTO): bool
    {
        return $this->verifyEmail($verifyEmailDTO);
    }

    /**
     * @param array $verifyEmailDTO
     * @return bool
     * @throws ValidationException
     */
    public function verifyEmail(array $verifyEmailDTO): bool
    {
        $token = $this->confirmTokenService->fetchByToken($verifyEmailDTO['token']);

        if (
            !$token
            || $token->created_at->gt(Carbon::now()->addSeconds(env('EXP_TIME_FOR_CONFIRM_EMAIL')))
        ) {
            throw ValidationException::withMessages([
                'token' => __('auth.verify_email.token_not_validate'),
            ]);
        }
        $user = User::findOrFail($token->user_id);
        if ($user->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'id' => __('auth.verify_email.verify_before'),
            ]);
        }

        return !$user->hasVerifiedEmail()
            && $user->markEmailAsVerified()
            && $this->confirmTokenService->deleteToken($user->id)
            && $user->notify(new WelcomeNotification());
    }
}
