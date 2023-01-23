<?php
declare(strict_types=1);

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Class UpdateCategoryRequest
 * @package App\Http\Requests\Category
 */
#[OA\Schema(
    required: ['name'],
    properties: [
        new OA\Property('name', description: 'Category name', type: 'string', maxLength: 255),
    ]
)]
class UpdateCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
        ];
    }
}
