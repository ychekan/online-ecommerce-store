<?php
declare(strict_types=1);

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * Class RefreshTokenResource
 * @package App\Http\Resources\Auth
 */
#[OA\Schema(
    properties: [
        new OA\Property('status', type: 'string'),
        new OA\Property('access_token', type: 'string'),
    ]
)]
class RefreshTokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|\Illuminate\Contracts\Support\Arrayable
    {
        return [
            'status' => 'success',
            'access_token' => $this->resource['token']
        ];
    }
}
