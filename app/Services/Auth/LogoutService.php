<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\Exceptions\UnauthorizedException;
use App\Exceptions\ValidationErrorException;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\AppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
/**
 * Class LoginService
 * @package App\Services\Auth
 */
class LogoutService extends AppService
{
    /**
     * @param LoginRequest $request
     * @return bool
     * @throws UnauthorizedException
     */
    public function run(Request $request): bool
    {
        return $this->login($request);
    }

    /**
     * @param Request $request
     * @return bool
     * @throws UnauthorizedException
     */
    private function login(Request $request): bool
    {
        if (!$request->user()) {
            throw new UnauthorizedException('Unauthorized');

        }
        auth('sanctum')->user()?->tokens()->delete();

        return true;
    }


}
