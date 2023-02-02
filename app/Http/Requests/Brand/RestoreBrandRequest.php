<?php
declare(strict_types=1);

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Class RestoreBrandRequest
 * @package App\Http\Requests\Brand
 */
#[OA\Schema(
    required: ['id'],
    properties: [
        new OA\Property(
            'id',
            description: 'Brands list for restore',
            type: 'array',
            items: new OA\Items(type: 'integer'),
        ),
    ]
)]
class RestoreBrandRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'array', 'min:1', 'max:20', 'exists:brands'],
            'id.*' => ['integer', ]
        ];
    }
}
