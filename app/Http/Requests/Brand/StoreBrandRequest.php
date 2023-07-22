<?php
declare(strict_types=1);

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Class StoreBrandRequest
 * @package App\Http\Requests\Brand
 */
#[OA\Schema(
    required: ['name'],
    properties: [
        new OA\Property('name', description: 'Brand name', type: 'string', maxLength: 255),
    ]
)]
class StoreBrandRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255', 'unique:brands'],
        ];
    }
}
