<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Class UpdateProfileRequest
 * @package App\Http\Requests\Profile
 */
#[OA\Schema(
    required: ['name'],
    properties: [
        new OA\Property('first_name', type: 'string', maxLength: 50),
        new OA\Property('last_name', type: 'string', maxLength: 50),
        new OA\Property('email', type: 'string', maxLength: 100),
        new OA\Property('phone', type: 'string', maxLength: 15),
        new OA\Property('city', type: 'string', maxLength: 30),
        new OA\Property('state', type: 'string', maxLength: 30),
        new OA\Property('zip', type: 'string', maxLength: 6),
        new OA\Property('country', type: 'string', maxLength: 30),
        new OA\Property('street', type: 'string', maxLength: 30),
        new OA\Property('apartment', type: 'string', maxLength: 30),
        new OA\Property('as_delivery_address', type: 'bool'),
    ]
)]
class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['string', 'max:50'],
            'last_name' => ['string', 'max:50'],
            'email' => ['email', 'max:100', 'unique:users,email'],
            'phone' => ['string', 'max:15'],
            'city' => ['string', 'max:30'],
            'state' => ['string', 'max:30'],
            'zip' => ['string', 'max:6'],
            'country' => ['string', 'max:30'],
            'street' => ['string', 'max:30'],
            'apartment' => ['string', 'max:30'],
            'as_delivery_address' => ['boolean'],
        ];
    }
}
