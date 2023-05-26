<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \App\Exceptions\JsonHttpException::class,
    ];

    /**
     * Render an exception into an HTTP response.
     * @throws Throwable
     */
    public function render($request, Throwable $e): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        // Force to application/json rendering on API calls
        if ($request->is('api*')) {
            // set Accept request header to application/json
            $request->headers->set('Accept', 'application/json');
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            throw new JsonHttpException('', 405);
        }

        if ($e instanceof AuthorizationException) {
            throw new JsonHttpException('', 403);
        }

        if ($e instanceof ThrottleRequestsException) {
            throw new JsonHttpException('', 429);
        }

        if ($e instanceof ModelNotFoundException) {
            throw new JsonHttpException('', 404);
        }

        if ($e instanceof \PDOException) {
            throw new JsonHttpException('', 500);
        }


        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (ModelNotFoundException $exception, $request) {
            return response()->json([
                'status' => 404,
                'message' => 'Record not found',
                'error' => 'Record not found',
            ], 404);
        });

        $this->reportable(function (Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
                'error' => $e->getTraceAsString(),
            ], 500);
        });
    }
}
