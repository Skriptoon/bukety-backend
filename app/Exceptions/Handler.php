<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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

    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);
        if (! app()->environment('local') && in_array($response->getStatusCode(), [500, 503, 404, 403])) {
            return response()->json([
                'success' => false,
                'error' => $e->showMessage ?? false
                    ? $e->getMessage()
                    : 'Произошла ошибка во время выполнения запроса.',
            ])->setStatusCode($response->getStatusCode());
        }

        if ($response->getStatusCode() === 419) {
            return response()->json([
                'success' => false,
                'error' => 'Срок действия страницы истек, обновите страницу',
            ])->setStatusCode($response->getStatusCode());
        }

        return $response;
    }
}
