<?php

namespace App\Common\Utils;


/**
 * Class CommonUtil
 *
 * @package App\Common\Utils
 */
class CommonUtil
{

    /**
     * notes: 获取当前环境是否开启dubug模式
     * author: jianjun.yan
     * date: 2019-05-15 21:53
     *
     * @return mixed
     */
    public static function checkDebug()
    {
        return env('APP_DEBUG', false);
    }
}
