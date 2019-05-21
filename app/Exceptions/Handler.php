<?php

namespace App\Exceptions;

use App\Common\Base\TobException;
use App\Common\Utils\ResultUtil;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Log;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class Handler extends ExceptionHandler
{

    static $info;
    static $http_status = 200;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     * 未被catach的异常在这处理
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        //var_dump(11);
        if (empty(self::$info)) {
            try {
                self::$info = '';
                throw $exception;
            } catch (MethodNotAllowedHttpException $e) { // Method限制异常处理
                self::$info = 'Only Limit ' . $e->getHeaders()['Allow'];
                self::$http_status = 405;
            } catch (ValidationException $e) { // 表单验证自定义message输出处理
                $customMessages = $exception->validator->getMessageBag()->getMessages();
                self::$info = array_pop($customMessages)[0];
            } catch (NotFoundHttpException $e) { // 404异常处理
                self::$info = 'The Request Url is 404';
                self::$http_status = 404;
            } catch (ServiceUnavailableHttpException $e) {
                self::$info = 'ServiceUnavailableHttpException';
                self::$http_status = 500;
            } catch (BadRequestHttpException $e) {
                self::$info = 'Accept header params error';
                self::$http_status = 400;
            } catch (\Exception $e) {

                $exception = $e;
            }


        }
        return ResultUtil::exception($exception, self::$info, self::$http_status);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param \Illuminate\Http\Request                 $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Unauthenticated.'
            ], 401);
        }

        return redirect()->guest(route('login'));
    }
}
