<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use OpenApi\Attributes as OA;

/**
 * Class SuccessResource
 * @package App\Http\Resources
 */
#[OA\Schema(
    properties: [
        new OA\Property('status', type: 'string', default: 'success'),
        new OA\Property('message', type: 'string', default: 'Success'),
        new OA\Property('code', type: 'integer', default: ResponseAlias::HTTP_OK),
    ]
)]
class SuccessResource extends JsonResource
{
    /**
     * @var string|null $message
     */
    protected string|null $message;

    public function __construct(string|null $message = null)
    {
        parent::__construct(null);
        $this->message = $message;
    }
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|JsonSerializable|Arrayable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'status' => 'success',
            'message' => $this->message ?? __('auth.success'),
            'code' => ResponseAlias::HTTP_OK,
        ];
    }
}
