<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\AppController;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Where;
use OpenApi\Attributes as OA;

/**
 * Class PermissionController
 * @package App\Http\Controllers\Api\Admin
 */
#[OA\Tag(name: 'Permission', description: 'Admin Permission endpoints')]
#[Middleware(['auth:sanctum', 'role:admin,manager'])]
#[Prefix('admin')]
#[Where('permission', '[0-9]+')]
class PermissionController extends AppController
{
    // todo policy

    // todo CRUD
}
