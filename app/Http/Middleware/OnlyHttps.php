<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\BadRequestException;

/**
 * HTTPS判定ミドルウェア
 *
 * Class OnlyHttps
 * @package App\Http\Middleware
 */
class OnlyHttps
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if ((empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== "on") 
            && app()->environment('production')) {

            throw new BadRequestException();
        }

        return $next($request);
    }
}
