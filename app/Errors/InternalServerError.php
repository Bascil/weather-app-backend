<?php

namespace App\Errors;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class InternalServerError extends Exception implements Throwable
{
    protected Throwable|null $previous;

    public function __construct($message, Throwable $e = null)
    {
        $this->message = $message;
        $this->previous = $e;
    }

    public function render(): JsonResponse
    {
        $error = [
            'message' => $this->message,
            'field' => "generic",
        ];
        if (env('APP_ENV') === 'local' && $this->previous) {
            $error['message'] = $this->previous->getMessage();
            $error['stacktrace'] = $this->previous->getTrace();
        }
        return response()->json([
            'errors' => [$error],
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
