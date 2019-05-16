<?php

namespace App\Common\Base;

use Throwable;

/**
 * exception 基类
 *
 * @author yjj
 *
 * todo 错误信息格式化
 * todo 增加对象找不到错误
 */
class TobException extends \Exception
{
    public function __construct($message, $code, Throwable $previous = null)
    {
        if (!$code) {
            $code = self::ERR_UNKNOWN;
        }
        parent::__construct($message, $code, $previous);
    }

    protected $trace;

    public function getLastTrace()
    {
        return $this->trace;
    }

    public function setLastTrace($trace)
    {
        $this->trace = $trace;
    }

    static function error($code, $exMessage = '')
    {
        $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        $message = self::getErrMsg($code);

        $exception = new self($message, $code);
        $exception->setLastTrace($traces[0]);
        //var_dump($exception->getFile());
        return $exception;
    }

    private static function getErrMsg($code)
    {
        $codeMap = static::getCodeMap();
        if (!isset($codeMap[$code])) {
            return "未定义的错误码[{$code}]";
        }
        return $codeMap[$code];
    }

    protected static function getCodeMap()
    {
        return self::ERR_CODE_MAP;
    }

    public static function assert($value, $code, $message = '')
    {
        if (value($value)) {
            return null;
        }

        throw static::error($code, $message);
    }

    public static function assertParam($value, $message = '')
    {
        return static::assert($value, self::ERR_PARAMS, $message);
    }
}