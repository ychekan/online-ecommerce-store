<?php
declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

/**
 * Class ForgotPasswordRequest
 * @package App\Http\Requests\Auth
 */
#[OA\Schema(
    required: ['email'],
    properties: [
        new OA\Property('email', description: 'User email', type: 'string', maxLength: 100),
    ]
)]
class ForgotPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'max:100',
                'exists:users,email',
                Rule::exists('users', 'email')
                    ->whereNotNull('email_verified_at'),
            ],
        ];
    }
}
