<?php
declare(strict_types=1);

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

/**
 * Class CategoryFilter
 * @package App\ModelFilters
 */
class CategoryFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    /**
     * @param string $category
     * @return CategoryFilter
     */
    public function name(string $category): CategoryFilter
    {
        return $this->where("name", "ILIKE", "%$category%");
    }
}
