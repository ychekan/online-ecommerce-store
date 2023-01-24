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
    required: ['name'],
    properties: [
        new OA\Property('first_name', description: 'User first name', type: 'string', maxLength: 255),
        new OA\Property('last_name', description: 'User last name', type: 'string', maxLength: 255),
        new OA\Property('email', description: 'User email', type: 'string', maxLength: 100),
        new OA\Property('password', description: 'User password', type: 'string', maxLength: 255),
        new OA\Property('password_confirmation', description: 'User password confirmation', type: 'string', maxLength: 255),
    ]
)]
class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed']
        ];
    }
}
