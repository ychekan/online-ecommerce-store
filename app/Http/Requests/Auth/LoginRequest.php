<?php
declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Rules\EmailVerifiedAtRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

/**
 * Class LoginRequest
 * @package App\Http\Requests\Auth
 */
#[OA\Schema(
    required: ['email', 'password'],
    properties: [
        new OA\Property('email', description: 'User email', type: 'string', maxLength: 100),
        new OA\Property('password', description: 'User password', type: 'string', maxLength: 50),
        new OA\Property('remeber_me', description: 'Remember me', type: 'boolean'),
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
            'email' => [
                'required',
                'email',
                new EmailVerifiedAtRule(),
                Rule::exists('users', 'email')->withoutTrashed()
            ],
            'password' => ['required'],
            'remember_me' => ['boolean', 'nullable'],
        ];
    }
}
