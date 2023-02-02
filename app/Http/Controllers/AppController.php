<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '0.1',
    title: 'React Online Store',
)]
#[OA\SecurityScheme(
    securityScheme: 'BearerAuth',
    type: 'http',
    bearerFormat: 'jwt',
    scheme: 'bearer'
)]
class AppController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
