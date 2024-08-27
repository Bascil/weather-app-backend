<?php

namespace App\Errors;

use Exception;
use Illuminate\Http\Response;

class ValidationError extends Exception
{
    private $field;
    public function __construct($message, $field)
    {
        $this->message = $message;
        $this->field = $field;
    }
    public function render($request)
    {
        return response()->json([
            'errors' => [[
                'message' => $this->message,
                'field' => $this->field,
            ]],
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
