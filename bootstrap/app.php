<?php

use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

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
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response(res_template([
                    'status_code' => 404,
                    'success'     => false,
                    'message'     => 'An error occurred. The information you requested could not be found',
                ]), 404);
            }
         });
        $exceptions->render(function (ClientException $e, Request $request) {
            if ($request->is('api/*')) {
                abort(400);
            }
         });

        $exceptions->render(function (DomainException $e, Request $request) {
            if ($request->is('api/*')) {
                return response(res_template([
                    'status_code' => 401,
                    'success'     => false,
                    'message'     => 'You are not logged in',
                ]), 401);
            }
        });

        $exceptions->render(function (RouteNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                return response(res_template([
                    'status_code' => 401,
                    'success'     => false,
                    'message'     => 'You are not logged in',
                ]), 401);
            }
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                    $errors = [];
                    foreach ($e->validator->getMessageBag()->getMessages() as $name => $error) {
                        $errors = array_merge($errors, [
                            $name => $error[0]
                        ]);
                    }
                    return response(res_template([
                        'status_code' => 422,
                        'success'     => false,
                        'message'     => 'The submitted data is not valid',
                        'errors'      => $errors,
                    ]), 422);
            }
        });

        $exceptions->render(function (ThrottleRequestsException $e, Request $request) {
            if ($request->is('api/*')) {
                return response(res_template([
                    'status_code' => 429,
                    'success'     => false,
                    'message'     => 'too much request!',
                ]), 429)->withHeaders($e->getHeaders());
            }
        });

        $exceptions->render(function (UnauthorizedException $e, Request $request) {
            if ($request->is('api/*')) {
                return response(res_template([
                    'status_code' => 403,
                    'success'     => false,
                    'message'     => 'You do not have access',
                ]), 403);
            }
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response(res_template([
                    'status_code' => 403,
                    'success'     => false,
                    'message'     => 'You do not have access',
                ]), 403);
            }
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response(res_template([
                    'error_code'  => 1001,
                    'status_code' => 401,
                    'success'     => false,
                    'message'     => 'You are not logged in',
                ]), 401);
            }
        });

        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response(res_template([
                    'status_code' => 403,
                    'success'     => false,
                    'message'     => 'You do not have access',
                ]), 403);
            }
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response(res_template([
                    'status_code' => 405,
                    'success'     => false,
                    'message'     => 'The method is not valid',
                ]), 405);
            }
        });
    })->create();
