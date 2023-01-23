<?php
declare(strict_types=1);

namespace App\Enums;

use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(
            'OrderStatusEnum',
            type: 'string',
            enum: ['created', 'pending', 'processing', 'delivery', 'delivered']
        ),
    ]
)]
enum OrderStatusEnum: string
{
    case CREATED = 'created';
    case PENDING = 'pending';
    case AWAITING_APPROVAL = 'awaiting_approval';
    case APPROVED = 'approved';
    case CUSTOMER_DECLINE = 'customer_decline';
    case MANAGER_DECLINE = 'manager_decline';
    case PROCESSING = 'processing';
    case IN_TRANSIT = 'in_transit';
    case DELIVERY = 'delivery';
    case DELIVERED = 'delivered';
}
