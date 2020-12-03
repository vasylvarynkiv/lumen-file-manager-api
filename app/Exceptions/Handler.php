<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if (!$request->expectsJson() && !$exception instanceof ValidationException) {
            if ($exception instanceof NotFoundHttpException) {
                $status = Response::HTTP_NOT_FOUND;
                $message = 'Route not found';
            } elseif ($exception instanceof ModelNotFoundException) {
                $status = Response::HTTP_NOT_FOUND;
                $message = 'Not found';
            } elseif ($exception instanceof FileNotFoundException) {
                $status = Response::HTTP_NOT_FOUND;
                $message = 'The file was not found';
            } elseif ($exception instanceof MethodNotAllowedHttpException) {
                $status = Response::HTTP_METHOD_NOT_ALLOWED;
                $message = 'Method not allowed';
            } else {
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
                $message = $exception->getMessage();
            }

            return response()->json(['message' => $message], $status);
        }

        return parent::render($request, $exception);
    }
}
