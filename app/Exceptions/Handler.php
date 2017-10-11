<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
//        if ($request->route() && collect($request->route()->computedMiddleware)->contains('api')) {
        if (Str::startsWith($request->getRequestUri(), '/api')) {
            if ($exception instanceof HttpException) {
                return response()->json(['success' => false, 'message' => class_basename($exception)], $exception->getStatusCode());
            } else if ($exception instanceof AuthenticationException) {
                return response()->json(['success' => false, 'message' => $exception->getMessage()], 401);
            } else if ($exception instanceof ValidationException) {
                return response()->json(['success' => false, 'message' => $exception->getMessage(), 'data' => $exception->errors()], $exception->status);
            } else {
                return response()->json(['success' => false, 'message' => $exception->getMessage().$exception->getFile().$exception->getLine()],
                    property_exists($exception, 'status') ? $exception->status : 500);
            }
        }

        return parent::render($request, $exception);
    }
}
