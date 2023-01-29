<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\PaginationTrait;
use App\Traits\SortableTrait;
use BinaryCats\Sku\HasSku;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Class Product
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $sku
 * @property float $price
 * @property string $description
 * @property float $available
 * @property float $sale
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static filter(array $all)
 * @method static create(array $toArray)
 * @method softDeletes()
 */
class Product extends Model
{
    use HasFactory;
    use HasSku;
    use Filterable;
    use SortableTrait;
    use SoftDeletes;
    use PaginationTrait;

    /**
     * fields available for sort
     * @var $sortables string[]
     */
    public array $sortables = [
        'name',
        'price',
        'available',
        'sale',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'description',
        'available',
        'sale',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'float',
        'available' => 'float',
        'sale' => 'float',
        'description' => 'string',
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
     * @param $value
     * @return string
     */
    public function getDescriptionAttribute($value): string
    {
        return $value ?? '';
    }

    /**
     * Get the post's image.
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return BelongsToMany
     */
    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    /**
     * @return BelongsToMany
     */
    public function brand(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class, 'product_brand');
    }
}
