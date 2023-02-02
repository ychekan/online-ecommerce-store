<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordReset
 * @package App\Models
 *
 * @property int $id
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static create(array $array)
 */
class PasswordReset extends Model
{
    use HasFactory;

    public $updated_at = false;
    protected $primaryKey = 'token';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'token'
    ];

    public static function generateToken(string $email)
    {
        return self::create([
                'email' => $email,
                'token' => bin2hex(random_bytes(32)),
            ]);
    }
}
