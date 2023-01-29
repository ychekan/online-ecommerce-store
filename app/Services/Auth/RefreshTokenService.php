<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\Exceptions\UnauthorizedException;
use App\Models\PersonalAccessToken;
use App\Models\User;
use App\Services\AppService;
use Illuminate\Http\Request;

/**
 * Class RefreshTokenService
 * @package App\Services\Auth
 */
class RefreshTokenService extends AppService
{
    /**
     * @param Request $request
     * @return array
     * @throws UnauthorizedException
     */
    public function run(Request $request): array
    {
        return $this->refreshToken($request);
    }

    /**
     * @param Request $request
     * @return array
     * @throws UnauthorizedException
     */
    private function refreshToken(Request $request): array
    {
        if (empty($token = $request->header('Authorization'))) {
            throw new UnauthorizedException();
        }

        $token = explode('Bearer ', $token);
        if(empty($token[1]) || empty($token = PersonalAccessToken::findToken($token[1]))) {
            throw new UnauthorizedException(__('auth.cant_find_token'));
        }

        if (!$token->tokenable instanceof User) {
            throw new UnauthorizedException(__('auth.cant_find_token_for_user'));
        }

        return [
            'token' => !in_array('remember', $token->abilities)
                ? $token->tokenable->createToken(env('APP_NAME'))->plainTextToken
                : $token->tokenable->createTokenWithExpirationTime(env('APP_NAME'), ['remember'])->plainTextToken
        ];
    }

}
