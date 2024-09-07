<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Services\Exceptions\ServiceExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (ServiceExceptionInterface $exception, $request) {
            return response()->json([
                'status'=>'error',
                'code'=>$exception->getErrorCode(),
                'message'=>$exception->getMessage(),
            ], $exception->getHttpStatusCode());
        });

        $exceptions->renderable(function (NotFoundHttpException $exception, $request) {
            return response()->json([
                'status'=>'error',
                'code'=>'resource.not_found',
                'message'=>'Запрашиваемый ресурс не найден',
            ], 404);
        });

        $exceptions->renderable(function (Exception $exception, $request) {
            return response()->json([
                'status'=>'error',
                'code'=>'internal_error',
                'message'=>'Внутренняя ошибка',
            ], 500);
        });
    })->create();
