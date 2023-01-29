<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\AccessDeniedException;
use App\Exceptions\UnauthorizedException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class Role
 * @package App\Http\Middleware
 */
class Role
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws UnauthorizedException
     * @throws AccessDeniedException
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            throw new UnauthorizedException();
        }

        $user = Auth::user();
        // Check if user has the role Admin then access is enable
        if($user->hasRole('admin')) {
            return $next($request);
        }

        foreach ($roles as $role) {
            // Check if user has the role This check will depend on how your roles are set up
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        throw new AccessDeniedException();
    }
}
