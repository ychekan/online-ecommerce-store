<?php
declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\Request;

/**
 * Trait SortableTrait
 * @package App\Traits
 */
trait SortableTrait
{
    /**
     * @param $query
     * @param Request $request
     * @return mixed
     */
    public function scopeSort($query, Request $request): mixed
    {
        $sortables = data_get($this, 'sortables', []);
        $sortBy = $request->has('sortBy') ? $request->input('sortBy') : null;
        $sortOrder = $request->has('sortOrder') ? $request->input('sortOrder') : 'asc';

        if ($sortBy && (count($sortables) === 0 || in_array($sortBy, $sortables))) {
            return $query->orderBy($sortBy, $sortOrder);
        }
        return $query;
    }
}
