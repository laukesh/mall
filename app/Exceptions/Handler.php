<?php

namespace App\Exceptions;

use App\Support\DatabaseExceptionMapper;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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

    /**
     * Render database constraint errors as user-friendly messages.
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof QueryException) {
            $message = DatabaseExceptionMapper::toUserMessage($e);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                    'error' => $message,
                ], 422);
            }

            $redirect = back();

            if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH')) {
                $redirect = $redirect->withInput();
            }

            return $redirect->with('error', $message);
        }

        return parent::render($request, $e);
    }
}
