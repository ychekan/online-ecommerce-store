<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\AppController;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Where;
use OpenApi\Attributes as OA;

/**
 * Class OrderPaymentController
 * @package App\Http\Controllers\Api\Admin
 */
#[Middleware(['auth:sanctum', 'role:admin,manager'])]
#[Prefix('admin')]
#[Where('order-payment', '[0-9]+')]
class OrderPaymentController extends AppController
{
    // todo policy

    // todo CRUD
}
