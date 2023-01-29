<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

/**
 * Class ResetVerificationEmailController
 * @package App\Http\Controllers\Api\Auth
 */
#[OA\Tag(name: 'App\Http\Controllers\Api\Auth\ResetVerificationEmailController', description: 'Reset Verification Email endpoints')]
class ResetVerificationEmailController extends AppController
{
    //
}
