<?php
declare(strict_types=1);

namespace App\Http\Resources\Auth;

use App\Http\Resources\User\ProfileResource;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * Class LoginResource
 * @package App\Http\Resources\Auth
 */
#[OA\Schema(
    properties: [
        new OA\Property('access_token', type: 'string'),
        new OA\Property(
            'user',
            ref: '#/components/schemas/ProfileResource'
        ),
    ]
)]
class LoginResource extends JsonResource
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
            'access_token' => $this->resource['token'],
            'user' => new ProfileResource($this->resource['user']),
        ];
    }
}
