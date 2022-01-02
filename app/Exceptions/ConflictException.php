<?php

namespace App\Exceptions;

use Exception;

/**
 * カスタム例外クラス: ConflictException 409
 *
 * Class ConflictException
 * @package App\Exceptions
 */
class ConflictException extends Exception
{

    /**
     * @var $message
     */
    protected $message;

    /**
     * ConflictException constructor
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
                'code'    => 409,
                'message' => $this->message
            ),
            409
        );
    }
}
