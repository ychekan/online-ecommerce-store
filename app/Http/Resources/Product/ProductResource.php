<?php
declare(strict_types=1);

namespace App\Http\Resources\Product;

use App\Http\Resources\Brand\BrandResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Image\ImageResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use OpenApi\Attributes as OA;

/**
 * Class ProductResource
 * @package App\Http\Resources\Product
 * @property mixed $response
 */
#[OA\Schema(
    properties: [
        new OA\Property('id', type: 'integer'),
        new OA\Property('name', type: 'string'),
        new OA\Property('slug', type: 'string'),
        new OA\Property('sku', type: 'string'),
        new OA\Property('price', type: 'number'),
        new OA\Property('description', type: 'string'),
        new OA\Property('available', type: 'integer'),
        new OA\Property('sale', type: 'number'),
        new OA\Property(
            'category',
            ref: '#/components/schemas/CategoryResource'
        ),
        new OA\Property(
            'brand',
            ref: '#/components/schemas/BrandResource'
        ),
        new OA\Property(
            'image',
            ref: '#/components/schemas/ImageResource'
        ),
    ]
)]
class ProductResource extends JsonResource
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
            "sku" => $this->sku,
            "price" => $this->price,
            "description" => $this->description,
            "available" => $this->available,
            "sale" => $this->sale,
            "category" => new CategoryResource($this->category->first()),
            "brand" => new BrandResource($this->brand->first()),
            "image" => new ImageResource($this->images->first()),
        ];
    }
}
