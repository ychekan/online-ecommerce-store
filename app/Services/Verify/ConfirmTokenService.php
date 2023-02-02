<?php
declare(strict_types=1);

namespace App\Services\Verify;

//use App\DTO\Auth\ConfirmEmailTokensDTO;
use App\DTO\Verify\ConfirmEmailTokensDTO;
use App\Models\ConfirmEmailTokens;
use App\Models\User;
use App\Services\AppService;
use Illuminate\Validation\ValidationException;

/**
 * Class ConfirmTokenService
 * @package App\Services\Verify
 */
class ConfirmTokenService extends AppService
{
    /**
     * @param User $user
     * @return mixed
     * @throws ValidationException
     */
    public function createToken(User $user): mixed
    {
        if (ConfirmEmailTokens::where(['user_id' => $user->id])->exists()) {
            $this->deleteToken($user->id);
        }
        $token = substr(hash('sha512', $user->email . mt_rand() . microtime()), 0, 50);

        return ConfirmEmailTokens::create(
            ConfirmEmailTokensDTO::validate([
                'user_id' => $user->id,
                'token' => $token,
            ])
        );
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function fetchByToken(string $token): mixed
    {
        return ConfirmEmailTokens::where(['token' => $token])->first();
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function deleteToken($userId): mixed
    {
        return ConfirmEmailTokens::where(['user_id' => $userId])->delete();
    }
}
