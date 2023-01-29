<?php
declare(strict_types=1);


namespace App\Traits;

use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;

/**
 * Trait SanctumHasApiTokens
 * @package App\Traits
 */
trait SanctumHasApiTokens
{
    /**
     * @param string $name
     * @param array $abilities
     * @return NewAccessToken
     */
    public function createTokenWithExpirationTime(string $name, array $abilities = ['*']): NewAccessToken
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
            'expired_at' => now()->addMinutes(config('sanctum.expiration_remember_me') ?? config('sanctum.expiration'))
        ]);

        return new NewAccessToken($token, $token->getKey().'|'.$plainTextToken);
    }
}
