<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\AppController;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Where;
use OpenApi\Attributes as OA;

/**
 * Class RoleController
 * @package App\Http\Controllers\Api\Admin
 */
#[OA\Tag(name: 'Role', description: 'Admin Role endpoints')]
#[Middleware(['auth:sanctum', 'role:admin,manager'])]
#[Prefix('admin')]
#[Where('role', '[0-9]+')]
class RoleController extends AppController
{
    // todo policy

    // todo CRUD
}
