<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\JsonRespondController;

/**
 * Api共通コントローラー
 *
 * Class ApiController
 * @package App\Http\Controllers\Api
 */
class ApiController extends Controller
{
    use JsonRespondController;
}
