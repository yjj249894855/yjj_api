<?php
namespace App\Exceptions;

use App\Common\Base\TobException;
use App\Common\Utils\ResultUtil;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Log;

class Handler extends ExceptionHandler
{

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
     * @return void
     */
    public function report(Exception $exception)
    {
        var_dump(1334);
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        var_dump(22334);
//        if($exception instanceof \Illuminate\Validation\ValidationException){
//            $data = $exception->validator->getMessageBag();
//            $msg = collect($data)->first();
//            if(is_array($msg)){
//                $msg = $msg[0];
//            }
//            return response()->json(['message'=>$msg],200);
//        }
//
//        if (in_array('api',$exception->guards())){
//            if($exception instanceof AuthenticationException){
//                return response()->json(['message'=>'token错误'],200);
//            }
//            if($exception instanceof ModelNotFoundException){
//                return response()->json(['message'=>'该模型未找到'],200);
//            }
//
//        }
//        var_dump(22335);
//        return parent::render($request, $exception);
//
//        parent::render($exception);
//        $class = get_class($exception);
//        var_dump($class);
        $file = $exception->getFile();
        $line = $exception->getLine();
        if($exception instanceof TobException){
            $trace = $exception->getLastTrace();
            $file = $trace['file'] ?? '文件路径未知';
            $line = $trace['line'] ?? '0';
        }
//        Log::error(
//            '[msg:' . $exception->getMessage() . ']' . '[file:' . $file . ']' . '[line:' .
//            $line . ']');
        try {

            throw $exception;
        } catch (MethodNotAllowedHttpException $e) { // Method限制异常处理

            $noticeMessage = 'Only Limit ' . $e->getHeaders()['Allow'];
        } catch (ValidationException $e) { // 表单验证自定义message输出处理

            $customMessages = $exception->validator->getMessageBag()->getMessages();
            $noticeMessage = array_pop($customMessages)[0];
        } catch (NotFoundHttpException $e) { // 404异常处理

            $noticeMessage = 'The Request Url is 404';
        } catch (\Exception $e) {

            $exception = $e;
        }

        if (! empty($noticeMessage)) {

            try {

                throw new \Exception($noticeMessage);
            } catch (\Exception $e) {

                $exception = $e;
            }
        }
        return ResultUtil::exception($exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
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
