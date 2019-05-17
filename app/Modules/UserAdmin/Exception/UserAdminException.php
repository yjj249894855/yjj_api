<?php

namespace App\Modules\UserAdmin\Exception;

use App\Common\Base\TobException;

/**
 * Class UserAdminException
 *
 * @package App\Modules\UserAdmin\Exception
 */
class UserAdminException extends TobException
{

    /**
     * notes: code map 映射
     * author: jianjun.yan
     * date: 2019-05-17 14:28
     *
     * @return array
     */
    protected static function getCodeMap()
    {
        return [
            1001001 => '登录失败，请检查用户名和密码',
        ];
    }
}
