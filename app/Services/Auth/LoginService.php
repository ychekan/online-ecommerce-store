<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\Exceptions\ValidationErrorException;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\AppService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Class LoginService
 * @package App\Services\Auth
 */
class LoginService extends AppService
{
    /**
     * @param array $credentials
     * @param LoginRequest $request
     * @return User|null
     * @throws ValidationErrorException
     * @throws ValidationException
     */
    public function run(array $credentials, LoginRequest $request): User|null
    {
        return $this->login(
            $credentials,
            $request
        );
    }

    /**
     * @param array $credentials
     * @param LoginRequest $request
     * @return User|null
     * @throws ValidationErrorException
     */
    private function login(array $credentials, LoginRequest $request): User|null
    {
        $user = User::firstWhere('email', $credentials['email']);

        // Check password
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new ValidationErrorException(__('auth.not_valid_credentials'));
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $user;
        }
        return null;
    }


}
