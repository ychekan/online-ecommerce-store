<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\AppController;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Where;
use OpenApi\Attributes as OA;

/**
 * Class OrderAddressController
 * @package App\Http\Controllers\Api\Admin
 */
#[OA\Tag(name: 'OrderAddressController', description: 'Admin Order Address endpoints')]
#[Middleware(['auth:sanctum', 'role:admin,manager'])]
#[Prefix('admin')]
#[Where('order-address', '[0-9]+')]
class OrderAddressController extends AppController
{
    // todo policy

    // todo CRUD
}
