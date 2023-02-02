<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\Exceptions\UnauthorizedException;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoginService
 * @package App\Services\Auth
 */
class LogoutService extends AppService
{
    /**
     * @param LoginRequest $request
     * @return void
     * @throws UnauthorizedException
     */
    public function run(Request $request): void
    {
        $this->login($request);
    }

    /**
     * @param Request $request
     * @return void
     * @throws UnauthorizedException
     */
    private function login(Request $request): void
    {
        try {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
        } catch (\Exception $e) {
            throw new UnauthorizedException($e->getMessage());
        }
    }
}
