<?php
declare(strict_types=1);

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

/**
 * Class ProductFilter
 * @package App\ModelFilters
 */
class ProductFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [''];

    /**
     * @param string $name
     * @return ProductFilter
     */
    public function name(string $name): ProductFilter
    {
        return $this->where("name", "ILIKE", "%$name%");
    }
}
