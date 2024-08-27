<?php

namespace App\Errors;

use Exception;
use Illuminate\Http\Response;

class BadRequestError extends Exception
{
    public function __construct($message)
    {
        $this->message = $message;
    }
    public function render()
    {
        return response()->json([
            'errors' => [[
                'message' => $this->message,
                'field' => "generic",
            ]],
        ], Response::HTTP_BAD_REQUEST);
    }
}
