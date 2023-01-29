<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

/**
 * Class VerificationController
 * @package App\Http\Controllers\Api\Auth
 */
#[OA\Tag(name: 'App\Http\Controllers\Api\Auth\VerificationController', description: 'Verification endpoints')]
class VerificationController extends AppController
{
    //
}
