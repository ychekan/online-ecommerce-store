<?php
declare(strict_types=1);

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use OpenApi\Attributes as OA;

/**
 * Class ProfilePasswordRequest
 * @package App\Http\Requests\Profile
 */
#[OA\Schema(
    required: ['current_password', 'password', 'password_confirmation'],
    properties: [
        new OA\Property('current_password', description: 'Current password from user', type: 'string', maxLength: 50),
        new OA\Property('new_password', description: 'New password', type: 'string', maxLength: 50),
        new OA\Property('new_password_confirmation', description: 'New password confirmation', type: 'string', maxLength: 50),
    ]
)]
class ProfilePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
                'max:50',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'new_password' => [
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
            'new_password_confirmation' => [
                'required',
                'string',
                'same:new_password',
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
