<?php
declare(strict_types=1);

namespace App\Http\Resources\User;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use OpenApi\Attributes as OA;

/**
 * Class UserResource
 * @package App\Http\Resources\User
 */
#[OA\Schema(
    properties: [
        new OA\Property('id', type: 'integer'),
        new OA\Property('first_name', type: 'string'),
        new OA\Property('last_name', type: 'string'),
        new OA\Property('email', type: 'string'),
        new OA\Property('role', type: 'string'),
    ]
)]
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|JsonSerializable|Arrayable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->resource->id,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
            'city' => $this->resource->city,
            'state' => $this->resource->state,
            'country' => $this->resource->country,
            'street' => $this->resource->street,
            'apartment' => $this->resource->apartment,
            'as_delivery_address' => $this->resource->as_delivery_address,
            'role' => $this->resource->getRoleNames()->first(),
        ];
    }
}
