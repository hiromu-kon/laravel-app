<?php

namespace App\Exceptions;

use Exception;

/**
 * カスタム例外クラス: ForbiddenException 403
 *
 * Class ForbiddenException
 * @package App\Exceptions
 */
class ForbiddenException extends Exception
{

    /**
     * report
     */
    public function report()
    {
        //
    }

    /**
     * render
     * 
     * @return JsonResponse
     */
    public function render()
    {
        return response()->json(
            array(
                "code"    => 403,
                "message" => "アクセス権限がありません。"
            ),
            403
        );
    }
}
