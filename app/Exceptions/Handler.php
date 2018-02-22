<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof AuthenticationException) {
            // 处理用户身份验证失败错误
            return Response::json([
               'code' => 10000,
               'message' => '用户尚未登录，请登录后重试'
            ], 401);
        } else if ($e instanceof ApiException) {
            // 处理系统内部接口错误
            return Response::json([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'data' => $e->getData()
            ], $e->getHttpCode());
        } else if ($e instanceof NotFoundHttpException) {
            // 处理系统内部对象未找到错误
            return Response::json([
                'code' => 404,
                'message' => '404 错误，请检查 URL 及路由配置是否正确'
            ], 404);
        }else {
            $data = [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
            if (App::environment('local')) {
                $data['trace'] = $e->getTraceAsString();
            }
            return Response::json($data, 500);
        }
    }
}
