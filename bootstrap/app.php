<?php

use App\Errors\NotFoundError;
use App\Errors\ValidationError;
use App\Http\Middleware\Cors;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        apiPrefix: 'api',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(Cors::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->render(function (NotFoundHttpException $e, Request $request) {
        //     if ($request->is('api/*')) {
        //         return response()->json([
        //             'message' => 'Record not found.',
        //         ], Response::HTTP_NOT_FOUND);
        //     }
        // });

        $exceptions->render(function (NotFoundError $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'errors' => [[
                        'message' => json_decode($e->getMessage())->error->message,
                    ]],
                ], json_decode($e->getMessage())->error->code);
            }
        });

        $exceptions->render(function (ValidationException $e, $request) {
            if ($request->is('api/*')) {
                $error = Arr::first($e->errors());
                $field = array_keys($e->errors())[0];

                return (new ValidationError(
                    $error[0],
                    $field,
                ))->render($request);
            }
        });

        $exceptions->render(function (HttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'errors' => [[
                        'message' => $e,
                    ]],
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });

    })->create();
