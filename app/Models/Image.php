<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Image
 * @package App\Models
 *
 * @property int $id
 * @property string $path
 * @property string $origin_name
 * @property string $extension
 * @property int $size
 * @property int $width
 * @property int $height
 * @property string $type
 * @property int $imageable_id
 * @property string $imageable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static create(array $toArray)
 */
class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'path',
        'origin_name',
        'extension',
        'size',
        'width',
        'height',
        'type',
        'imageable_id',
        'imageable_type',
    ];

    // Relationships
    /**
     * Get the parent imageable model (user or post).
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
