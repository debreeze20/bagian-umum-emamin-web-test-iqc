<?php

namespace App\Exceptions;

use App\Helpers\ResponseFormatter;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\DB;
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
     *
     * @return void
     */
    public function register()
    {
        if (DB::transactionLevel() > 0) {
            DB::rollBack();
        }

        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($request->expectsJson()) {
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                    return ResponseFormatter::error([
                        'exception_class' => get_class($e),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        // 'trace' => $e->getTraceAsString()
                    ], $e->getMessage(), $e->getStatusCode());
                } else {
                    if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                        return ResponseFormatter::error([
                            'exception_class' => get_class($e),
                            'file' => $e->getFile(),
                            'line' => $e->getLine(),
                            // 'trace' => $e->getTraceAsString()
                        ], $e->getMessage(), 401);
                    } else {
                        return ResponseFormatter::error([
                            'exception_class' => get_class($e),
                            'file' => $e->getFile(),
                            'line' => $e->getLine(),
                            // 'trace' => $e->getTraceAsString()
                        ], $e->getMessage(), 500);
                    }
                }
            }
        });
    }
}
