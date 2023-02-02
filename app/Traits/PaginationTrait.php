<?php
declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\Request;

/**
 * Trait PaginationTrait
 * @package App\Traits
 */
trait PaginationTrait
{
    /**
     * @param $query
     * @param Request $request
     * @return mixed
     */
    public function scopePaginateLimit($query, Request $request): mixed
    {
        $perPage = $request->has('perPage') && $request->input('perPage') <= 20
            ? $request->input('perPage')
            : 20;
        $page = $request->has('page') && (int)$request->input('page') <= 0
            ? $request->input('page')
            : 0;

        return $query->paginate($perPage, '*', $page);
    }
}
