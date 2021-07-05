<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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

    public function render($request, Throwable $e)
    {
        if ($request->wantsJson()) {
            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'data' => null,
                    'type' => 'error',
                    'meesage' => 'Object not found',
                ], 404);
            } elseif ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'data' => null,
                    'type' => 'error',
                    'meesage' => 'Object not found',
                ], 404);
            } elseif ($e instanceof UnsupportedLanguageException) {
                return response()->json([
                    'data' => null,
                    'type' => 'error',
                    'meesage' => $e->getMessage(),
                ], $e->getCode());
            } elseif ($e instanceof HttpException) {
                return response()->json([
                    'data' => null,
                    'type' => 'error',
                    'meesage' => $e->getMessage(),
                ], 404);
            }
        }

        return parent::render($request, $e);
    }
}
