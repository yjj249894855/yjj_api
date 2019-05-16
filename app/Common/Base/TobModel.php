<?php

namespace App\Common\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TobModel
 *
 * @package App\Common\Base
 */
class TobModel extends Model
{
    //全局配置-软删除
    const IS_NOT_DELETED = 1;
    const IS_DELETED = 2;


    //默认的数据库连接
    /**
     * @var string
     */
    protected $connection = 'mysql-tob-common';

    //-暂定
    //public $timestamps = true;

    /**
     * TobModel constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * notes:
     * author: jianjun.yan
     * date: 2019-05-15 16:26
     */
    static function beginTransaction()
    {
        self::getConnectionResolver()->connection()->beginTransaction();
    }

    /**
     * notes:
     * author: jianjun.yan
     * date: 2019-05-15 16:26
     */
    static function commit()
    {
        self::getConnectionResolver()->connection()->commit();
    }

    /**
     * notes:
     * author: jianjun.yan
     * date: 2019-05-15 16:26
     */
    static function rollBack()
    {
        self::getConnectionResolver()->connection()->rollBack();
    }

}

