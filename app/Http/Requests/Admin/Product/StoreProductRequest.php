<?php
declare(strict_types=1);

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Class StoreProductRequest
 * @package App\Http\Requests\Product
 */
#[OA\Schema(
    required: ['name', 'price'],
    properties: [
        new OA\Property('name', description: 'Product name', type: 'string', maxLength: 255),
        new OA\Property('price', description: 'Product price', type: 'number', maximum: 10000, minimum: 0, ),
        new OA\Property('description', description: 'Product description', type: 'string', maxLength: 10000),
        new OA\Property(
            'available',
            description: 'Product available qty',
            type: 'integer',
            maximum: 1000,
            minimum: 0,
        ),
        new OA\Property(
            'sale',
            description: 'Product sale %',
            type: 'number',
            maximum: 100,
            minimum: 0,
        ),
    ]
)]
class StoreProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'max:' . config('constants.max_product_price')],
            'description' => ['string', 'max:10000'],
            'available' => ['integer', 'min:0', 'max:1000'],
            'sale' => ['numeric', 'min:0', 'max:100'],
        ];
    }
}
