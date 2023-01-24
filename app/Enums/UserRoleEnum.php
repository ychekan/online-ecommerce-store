<?php
declare(strict_types=1);

namespace App\Enums;

use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(
            'UserRoleEnum',
            type: 'string',
            enum: ['admin', 'user', 'manager']
        ),
    ]
)]
enum UserRoleEnum: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case MANAGER = 'manager';
}
