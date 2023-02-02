<?php
declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use OpenApi\Attributes as OA;

/**
 * Class ResetPasswordRequest
 * @package App\Http\Requests\Auth
 */
#[OA\Schema(
    required: ['token', 'password', 'password_confirmation'],
    properties: [
        new OA\Property('token', description: 'Token from email', type: 'string', maxLength: 100),
        new OA\Property('password', description: 'User password', type: 'string', maxLength: 50),
        new OA\Property('password_confirmation', description: 'User password confirmation', type: 'string', maxLength: 50),
    ]
)]
class ResetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'token' => ['required', 'string', 'max:100'],
            'password' => [
                'required',
                'string',
                'confirmed',
                'max:50',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'password_confirmation' => [
                'required',
                'string',
                'same:password',
                'max:50',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ];
    }
}
