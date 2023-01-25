<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Class StoreProductRequest
 * @package App\Http\Requests\Product
 */
#[OA\Schema(
    required: ['id'],
    properties: [
        new OA\Property(
            'id',
            description: 'Products list for restore',
            type: 'array',
            items: new OA\Items(type: 'integer'),
        ),
    ]
)]
class RestoreProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'array', 'min:1', 'max:20', 'exists:products'],
            'id.*' => ['integer', ]
        ];
    }
}
