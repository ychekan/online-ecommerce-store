<?php
declare(strict_types=1);

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

/**
 * Class BrandFilter
 * @package App\ModelFilters
 */
class BrandFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    /**
     * @param string $brand
     * @return BrandFilter
     */
    public function name(string $brand): BrandFilter
    {
        return $this->where("name", "ILIKE", "%$brand%");
    }
}
