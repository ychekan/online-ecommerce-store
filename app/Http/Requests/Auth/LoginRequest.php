<?php
declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Class LoginRequest
 * @package App\Http\Requests\Auth
 */
#[OA\Schema(
    required: ['email', 'password'],
    properties: [
        new OA\Property('email', description: 'User email', type: 'email', maxLength: 100),
        new OA\Property('password', description: 'User password', type: 'string', maxLength: 255),
    ]
)]
class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }
}
