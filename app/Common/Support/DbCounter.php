<?php

namespace App\Common\Support;

use Illuminate\Support\Facades\App;

/**
 * Class DbCounter
 *
 * @package App\Common\Support
 */
class DbCounter
{
    /**
     * @var array
     */
    static $sqls = [];

    /**
     * notes:
     * author: jianjun.yan
     * date: 2019-05-15 21:45
     *
     * @param $sql
     */
    static function logSql($sql)
    {
        //命令行中不记录sql，防止内存泄漏
        if (App::runningInConsole()) {
            return;
        }
        self::$sqls[] = $sql;
    }

    /**
     * notes: 获取当前执行的sql
     * author: jianjun.yan
     * date: 2019-05-15 21:45
     *
     * @return array
     */
    static function info()
    {
        $sqlCount = count(self::$sqls);

        $ret = ['all' => $sqlCount];
        foreach (self::$sqls as $sql) {
            list($type, $_) = explode(' ', $sql, 2);
            $type = strtolower($type);
            !isset($ret[$type]) && $ret[$type] = 0;
            $ret[$type] += 1;
        }
        $cnt = array_count_values(self::$sqls);
        $ret['detail'] = $cnt;

        return $ret;
    }
}