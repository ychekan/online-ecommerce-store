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
 * Class Category
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @method static create(array $toArray)
 */
class Category extends Model
{
    use HasFactory;
    use Filterable;
    use SortableTrait;
    use SoftDeletes;
    use PaginationTrait;
    use Filterable;
    use SortableTrait;

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
        'slug',
        'parent_id',
    ];

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

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
     * Get the post's image.
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
