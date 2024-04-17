<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

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
        $this->renderable(function (ObjectNotFoundException $e, Request $request) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        });

        $this->renderable(function (SemSaldoException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
            }
        });

        $this->renderable(function (ValidationException $e, Request $request) {
            return $this->convertValidationExceptionToResponse($e, $request);
        });

        $this->renderable(function (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }
}
