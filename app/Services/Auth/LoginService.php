<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\Exceptions\ValidationErrorException;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\AppService;
use Illuminate\Support\Facades\Hash;
/**
 * Class LoginService
 * @package App\Services\Auth
 */
class LoginService extends AppService
{
    /**
     * @param array $credentials
     * @param LoginRequest $request
     * @return array
     * @throws ValidationErrorException
     */
    public function run(array $credentials, LoginRequest $request): array
    {
        return $this->login(
            $credentials,
            $request
        );
    }

    /**
     * @param array $credentials
     * @param LoginRequest $request
     * @return array
     * @throws ValidationErrorException
     */
    private function login(array $credentials, LoginRequest $request): array
    {
        $user = User::firstWhere('email', $credentials['email']);

        // Check password
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new ValidationErrorException(__('auth.not_valid_credentials'));
        }

        $token = $request->filled('remember_me')
            ? $user->createTokenWithExpirationTime(env('APP_NAME'), ['remember'])->plainTextToken // Remember me
            : $user->createToken(env('APP_NAME'))->plainTextToken; // Without remember me

        return [
            'user' => $user,
            'token' => $token
        ];
    }


}
