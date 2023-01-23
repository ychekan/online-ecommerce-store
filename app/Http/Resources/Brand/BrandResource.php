<?php
declare(strict_types=1);

namespace App\Http\Resources\Brand;

use App\Http\Resources\Image\ImageResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use OpenApi\Attributes as OA;

/**
 * Class BrandResource
 * @package App\Http\Resources\Brand
 */
#[OA\Schema(
    properties: [
        new OA\Property('id', type: 'integer'),
        new OA\Property('name', type: 'string'),
        new OA\Property('slug', type: 'string'),
        new OA\Property(
            'image',
            ref: '#/components/schemas/ImageResource'
        ),
    ]
)]
class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "image" => new ImageResource($this->images->first()),
        ];
    }
}
