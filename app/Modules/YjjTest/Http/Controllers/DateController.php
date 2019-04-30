<?php

namespace App\Modules\YjjTest\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Common\Utils\LogUtils;
use App;
use App\Modules\YjjTest\Exception\EmployeeException;



/**
 * 测试
 * @author yjj
 */
class DateController
{

    public function demo1()
    {

        try {
            throw EmployeeException::error(2000104);
            $aa = date("Y/m/d H:i:s");
            var_dump($aa);
            var_dump($aawww);
        } catch (\Exception $e) {
            LogUtils::catch_error($e);
        }
        die;
        try {
            $aa = date("Y/m/d H:i:s");
            $cc = storage_path('logs/laravel2.log');
            //throw new \Exception("ats分库设置错误");
            //throw $aa;
            var_dump($ccwww);
            Log::emergency("系统挂掉了");
            Log::alert("数据库访问异常");
            Log::critical("系统出现未知错误");
            Log::error("指定变量不存在");
            Log::warning("该方法已经被废弃");
            Log::notice("用户在异地登录");
            Log::info("用户xxx登录成功");
            Log::debug("调试信息");
            Log::channel('aaa')->info('aaaaaa');
            return $aa;
        } catch (\Exception $e) {
            echo $e->getMessage();
            report($e);
            Log::error($e->getMessage());
            //throw EmployeeException::error(2000104);
        }
    }

    public function demo22(){
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
