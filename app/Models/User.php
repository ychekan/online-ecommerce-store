<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\PaginationTrait;
use App\Traits\SanctumHasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * @package App\Models
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $country
 * @property string $street
 * @property string $apartment
 * @property string $as_delivery_address
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static create(array $toArray)
 * @method static firstWhere(string $string, array|string|null $cookie)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles;
    use HasApiTokens;
    use SanctumHasApiTokens;
    use HasFactory;
    use Notifiable;
    use PaginationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'city',
        'state',
        'zip',
        'country',
        'street',
        'apartment',
        'as_delivery_address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'as_delivery_address' => 'boolean',
    ];

    /**
     * Encrypts the user's password.
     *
     * @return Attribute
     */
    protected function password(): Attribute
    {
        return Attribute::set(
            set: fn($value) => Hash::make($value),
        );
    }
}
