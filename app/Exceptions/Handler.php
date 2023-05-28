<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Auth\Access\AuthorizationException;

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
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /*public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            // Tratar o erro "Not Found"

            return response()->view('errors.notfound', [], 404);
        } elseif ($exception instanceof AccessDeniedHttpException || $exception instanceof AuthorizationException) {
            // Tratar o erro "Forbidden"

            return response()->view('errors.authorization', [], 403);
        } else {
            // Tratar outros erros gerais

            return response()->view('errors.error', [], 500);
        }

        //return parent::render($request, $exception);
    }*/
}
