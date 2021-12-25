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
     * @var $message
     */
    protected $message;

    /**
     * ForbiddenException constructor
     * 
     * @param $message
     */
    public function __construct($message)
    {

        $this->message = $message;
    }

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
                "message" => $this->message
            ),
            403
        );
    }
}
