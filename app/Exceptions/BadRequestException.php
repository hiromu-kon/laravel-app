<?php

namespace App\Exceptions;

use Exception;

/**
 * カスタム例外クラス: BadRequestException 400
 *
 * Class BadRequestException
 * @package App\Exceptions
 */
class BadRequestException extends Exception
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
                'code'    => 400,
                'message' => 'リクエストが不正です。'
            ),
            400
        );
    }
}
