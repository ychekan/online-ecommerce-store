<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\PaginationTrait;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
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
 * @method static findOrFail($user_id)
 * @method static findByEmail(mixed $email)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles;
    use HasApiTokens;
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

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        // The trick is first to instantiate the notification itself
        $notification = new ResetPassword($token);
        // Then use the createUrlUsing method
        $notification->createUrlUsing(function ($token) {
            return Config::get('app.frontend_url');
        });
        // Then you pass the notification
        $this->notify($notification);
    }

    // Scopes
    /**
     * @param $query
     * @param $email
     * @return Model|HasOne|null
     */
    public function scopeFindByEmail($query, $email): Model|HasOne|null
    {
        return $query->where('email', $email)->first();
    }

    // Relationships
    /**
     * @return Model|HasOne|null
     */
    public function getVerificationToken(): Model|HasOne|null
    {
        return $this->hasOne(ConfirmEmailTokens::class, 'user_id', 'id')->first();
    }
}
