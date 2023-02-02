<?php
declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Class VerifyEmailRequest
 * @package App\Http\Requests\Verify
 */
#[OA\Schema(
    required: ['id', 'token'],
    properties: [
        new OA\Property('id', description: 'User id', type: 'integer'),
        new OA\Property('token', description: 'Verify token', type: 'string', maxLength: 100),
    ]
)]
class VerifyEmailRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:users,id'],
            'token' => ['required', 'string', 'exists:confirm_email_tokens,token'],
        ];
    }
}
