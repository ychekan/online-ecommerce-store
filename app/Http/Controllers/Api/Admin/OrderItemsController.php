<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\AppController;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Where;
use OpenApi\Attributes as OA;

/**
 * Class OrderItemsController
 * @package App\Http\Controllers\Api\Admin
 */
#[OA\Tag(name: 'OrderItems', description: 'Admin Order Item endpoints')]
#[Middleware(['auth:sanctum', 'role:admin,manager'])]
#[Prefix('admin')]
#[Where('order-item', '[0-9]+')]
class OrderItemsController extends AppController
{
    // todo policy

    // todo CRUD
}
