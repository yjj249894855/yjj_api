<?php

namespace App\Common\Utils;

use App\Common\Base\TobException;
use App\Common\Support\DbCounter;

/**
 * Class ResultUtil
 * Response 返回相关操作
 *
 * @package App\Common\Utils
 */
class ResultUtil
{

    /**
     * notes:
     * author: jianjun.yan
     * date: 2019-05-15 21:43
     *
     * @param        $data
     * @param int    $code
     * @param string $msg
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data, $code = 0, $msg = 'success')
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        if (CommonUtil::checkDebug()) {
            /**
             * sql统计
             */
            $result['debug']['sql'] = [DbCounter::info()];
        }
        return response()->json($result);
    }


    /**
     * notes:
     * author: jianjun.yan
     * date: 2019-05-15 21:43
     *
     * @param \Exception $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function exception(\Exception $exception, $msg = '')
    {
        if (empty($msg)) {
            $msg = $exception->getMessage();
        }
        $code = $exception->getCode();
        if (!$code) {
            $code = -99;
        }
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => []
        ];
        if (CommonUtil::checkDebug()) {

            /**
             * 保存异常堆栈
             */
            $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            //$result['debug']['trances'] = $traces;
            //$result['traces'] = $exception->getTraceAsString();
            $result['traces'] = $traces;
            $file = $exception->getFile();
            $line = $exception->getLine();

            /**
             * 处理自定义异常的发生位置
             */
            if ($exception instanceof TobException) {
                $trace = $exception->getLastTrace();
                $file = $trace['file'];
                $line = $trace['line'];
            }
            $result['debug'] = [$file, $line];

            /**
             * sql统计
             */
            $result['debug']['sql'] = DbCounter::info();
        }

        //var_dump($result);die;
        return response()->json($result);
    }

    /**
     * notes:
     * author: jianjun.yan
     * date: 2019-05-15 21:43
     *
     * @param       $msg
     * @param int   $code
     * @param array $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function failed($exception, $data = '')
    {
        $code = $exception->getCode();
        $msg = $exception->getMessage();
        // 不允许code为0-失败场景
        if ($code == 0) {
            $code = -99;
        }
        $result = [
            'msg' => $msg,
            'code' => $code,
            'data' => $data,
        ];
        if (CommonUtil::checkDebug()) {
            /**
             * sql统计
             */
            $result['debug']['sql'] = DbCounter::info();

            $traces = [];
            $str_url = self::file_str_replace($exception->getFile());
            $file_new_tmp = $exception->getTrace()[0]['file'];
            $file_new = self::file_str_replace($file_new_tmp);
            $line_new = $exception->getTrace()[0]['line'];
            $traces['code'] = $exception->getCode();
            $traces['message'] = $exception->getMessage();
            $traces['file'] = $str_url;
            $traces['line'] = $exception->getLine();
            if ($file_new != $str_url) {
                $traces['file_new'] = $file_new;
                $traces['line_new'] = $line_new;
            }
            $result['debug']['trances'] = $traces;
        }
        return response()->json($result);
    }

    private static function file_str_replace($file_url)
    {
        $file_la = env('LARAVEL_URL', '');
        $str_url = $file_url;
        if ($file_la) {
            $str_url = str_replace($file_la, '', $file_url);
        }
        return $str_url;
    }
}
