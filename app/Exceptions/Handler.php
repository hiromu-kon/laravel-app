<?php

namespace App\Exceptions;

use App\Traits\JsonRespondController;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    use JsonRespondController;

    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Throwable               $exception
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {

        if (!config("app.debug") && ($request->ajax() || $request->is("api/*"))) {

            $status = 400;
            if ($this->isHttpException($exception)) {

                $status = $exception->getStatusCode();
            }

            if ($this->shouldReport($exception) && !$this->isHttpException($exception)) {
                $status = 500;
            }

            return $this->setHTTPStatusCode($status)
                ->respondWithError($exception->getMessage());
        }

        return parent::render($request, $exception);
    }
}
