<?php
declare(strict_types=1);

namespace App\DTO;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Normalizers\ArrayNormalizer;
use Spatie\LaravelData\Normalizers\JsonNormalizer;
use Spatie\LaravelData\Normalizers\ModelNormalizer;
use Spatie\LaravelData\Normalizers\ObjectNormalizer;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Wrapping\WrapExecutionType;
use Spatie\LaravelData\Transformers\Transformer;

/**
 * Class AbstractDTO
 * @package App\DTO
 */
class AbstractDTO extends Data
{
}
