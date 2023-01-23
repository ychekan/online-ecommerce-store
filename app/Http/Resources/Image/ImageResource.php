<?php
declare(strict_types=1);

namespace App\Http\Resources\Image;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use OpenApi\Attributes as OA;

/**
 * Class ImageResource
 * @package App\Http\Resources\ImageResource
 */
#[OA\Schema(
    properties: [
        new OA\Property('id', type: 'integer'),
        new OA\Property('path', type: 'string'),
        new OA\Property('origin_name', type: 'string'),
        new OA\Property('width', type: 'string'),
        new OA\Property('height', type: 'string'),
    ]
)]
class ImageResource extends JsonResource
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
            "id" => $this->id,
            "path" => $this->path,
            "origin_name" => $this->origin_name,
            "width" => $this->width,
            "height" => $this->height,
        ];
    }
}
