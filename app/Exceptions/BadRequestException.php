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
     * @var $message
     */
    protected $message;

    /**
     * BadRequestException constructor
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
                "code"    => 400,
                "message" => $this->message
            ),
            400
        );
    }
}
