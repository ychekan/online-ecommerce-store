<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

/**
 * Class ForgotPasswordController
 * @package App\Http\Controllers\Api\Auth
 */
#[OA\Tag(name: 'App\Http\Controllers\Api\Auth\ForgotPasswordController', description: 'Forgot Password endpoints')]
class ForgotPasswordController extends AppController
{
    //
}
