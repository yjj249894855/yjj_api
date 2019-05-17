<?php
namespace App\Modules\UserAdmin\Exception;

use App\Common\Base\TobException;

class UserAdminException extends TobException
{

    protected static function getCodeMap()
    {
        return [
            1001001 => '登录失败，请检查用户名和密码',

        ];
    }
}
