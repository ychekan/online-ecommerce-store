<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\AppController;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Where;
use OpenApi\Attributes as OA;

/**
 * Class OrderController
 * @package App\Http\Controllers\Api\Admin
 */
#[OA\Tag(name: 'OrderController', description: 'Admin Order endpoints')]
#[Middleware(['auth:sanctum', 'role:admin,manager'])]
#[Prefix('admin')]
#[Where('order', '[0-9]+')]
class OrderController extends AppController
{
    // todo policy

    // todo CRUD
}
