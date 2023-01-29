<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

/**
 *
 * @property mixed $id
 * @property mixed $tokenable_type
 * @property mixed $tokenable_id
 * @property mixed $name
 * @property mixed $token
 * @property mixed $abilities
 * @property mixed $last_used_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $expired_at
 * @property mixed $deleted_at
 * @property mixed $currentAccessToken
 * @property mixed $tokens
 * @property mixed $tokenable
 */
class PersonalAccessToken extends SanctumPersonalAccessToken
{
    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
        'created_at',
        'updated_at',
        'expired_at',
    ];

    protected $dates = ['expired_at'];
}
