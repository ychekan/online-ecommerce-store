<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\PaginationTrait;
use App\Traits\SortableTrait;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Class Brand
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @method static create(array $toArray)
 * @method static filter(array $all)
 * @method softDeletes()
 */
class Brand extends Model
{
    use HasFactory;
    use Filterable;
    use SortableTrait;
    use SoftDeletes;
    use Filterable;
    use SortableTrait;
    use PaginationTrait;

    /**
     * fields available for sort
     * @var $sortables string[]
     */
    public array $sortables = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Generate slug name
     *
     * @return Attribute
     */
    protected function name(): Attribute
    {
        return new Attribute(
            set: fn($value) => [
                'slug' => Str::slug($value),
                'name' => $value
            ],
        );
    }

    /**
     * Get the brand images.
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
