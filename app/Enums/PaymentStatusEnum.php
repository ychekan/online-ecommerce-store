<?php
declare(strict_types=1);


namespace App\Enums;
use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(
            'PaymentStatusEnum',
            type: 'string',
            enum: ['unpaid', 'paid', 'pending', 'canceled']
        ),
    ]
)]
enum PaymentStatusEnum: string
{
    case UNPAID = 'unpaid';
    case PENDING = 'pending';
    case PAID = 'paid';
    case CANCELED = 'canceled';
}
