<?php
declare(strict_types=1);

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Class RestoreCategoryRequest
 * @package App\Http\Requests\Category
 */
#[OA\Schema(
    required: ['id'],
    properties: [
        new OA\Property(
            'id',
            description: 'Categories list for restore',
            type: 'array',
            items: new OA\Items(type: 'integer'),
        ),
    ]
)]
class RestoreCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'array', 'min:1', 'max:20', 'exists:categories'],
            'id.*' => ['integer', ]
        ];
    }
}
