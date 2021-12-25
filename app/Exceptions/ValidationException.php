<?php

namespace App\Exceptions;

use Exception;

/**
 * カスタム例外クラス: ValidationException 422
 *
 * Class ValidationException
 * @package App\Exceptions
 */
class ValidationException extends Exception
{

    /**
     * @var $message
     */
    protected $message;

    /**
     * ValidationException constructor
     * 
     * @param $message
     */
    public function __construct($validator)
    {

        $this->validator = $validator;
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
                "code"    => 422,
                "message" => $this->validator->errors()
            ),
            422
        );
    }
}
