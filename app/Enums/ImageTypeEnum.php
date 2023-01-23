<?php
declare(strict_types=1);

namespace App\Enums;

use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(
            'ImageTypeEnum',
            type: 'string',
            enum: [
                'emotional',
                'financial',
                'functional',
                'trend',
                'potential_customer_offering',
                'operational_priority',
            ]
        ),
    ]
)]
enum ImageTypeEnum: string
{
    case MAIN_IMAGE = 'main_image';
    case ADDITIONAL = 'additional';
}
