<?php
namespace App\Common\Utils;

use Illuminate\Support\Facades\Log;

/**
 * 日志工具类
 * 
 * @author  yjj
 */
class LogUtils
{

    /**
     * 获取throw错误的相关信息
     * 
     * @param   $e
     * @return  string
     */
    private static function getThrowStr($e,$params = '')
    {
        $str_url = self::file_str_replace($e->getFile());
        $file_new_tmp = $e->getTrace()[0]['file'];
        $file_new = self::file_str_replace($file_new_tmp);
        $line_new = $e->getTrace()[0]['line'];
        $str = '';
        $str .= "\nstart---\n";
        $str .= "params:".(string)$params."\n";
        $str .= "code:".$e->getCode()."\n";
        $str .= "message:".$e->getMessage()."\n";
        $str .= "file:".$str_url."\n";
        $str .= "line:".$e->getLine()."\n";
        if($file_new != $str_url){
            $str .= "file_new:".$file_new."\n";
            $str .= "line_new:".$line_new."\n";
        }
        $str .= "end---";
        return $str;
    }

    /**
     * 获取throw错误的相关信息
     *
     * @param   $e
     * @return  string
     */
    public static function getThrowArr($e)
    {
        $str_url = self::file_str_replace($e->getFile());
        $file_new_tmp = $e->getTrace()[0]['file'];
        $file_new = self::file_str_replace($file_new_tmp);
        $arr = [];
        $arr['code'] = $e->getCode();
        $arr['message'] = $e->getMessage();
        $arr['file'] = $str_url;
        $arr['line'] = $e->getLine();
        if($file_new != $str_url){
            $line_new = $e->getTrace()[0]['line'];
            $arr['file_new'] = $file_new;
            $arr['line_new'] = $line_new;
        }
        return $arr;
    }

    /**
     * 文件路径替换
     * 
     * @param   $e
     * @return  string
     */
    private static function file_str_replace($file_url)
    {
        $file_la = env('LARAVEL_URL' ,'');
        $str_url = $file_url;
        if($file_la){
            $str_url = str_replace($file_la, '', $file_url);
        }
        return $str_url;
    }
    /**
     * debug
     * 
     * @param   $message
     */
    public static function debug($message)
    {
        Log::channel('debug')->debug($message);
    }
    
    /**
     * info
     * 
     * @param   $message
     */
    public static function info($message)
    {
        var_dump(__CLASS__);
        var_dump(__FUNCTION__);
        Log::channel('info')->info($message);
    }
    
    /**
     * catch_error
     * 
     * @param   $message
     */
    public static function catch_error($message,$params = '')
    {
        $str = self::getThrowStr($message,$params);
        Log::channel('catch_error')->error($str);
        return $str;
    }
}