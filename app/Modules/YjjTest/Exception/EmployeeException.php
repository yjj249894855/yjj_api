<?php
namespace App\Modules\YjjTest\Exception;

use App\Common\Base\TobException;

class EmployeeException extends TobException
{

    protected static function getCodeMap()
    {
        return [
            2000001 => '您只能设置一个月内的可面试时！',
            
            //WechatService
            2000102 => '微信公众号生成二维码失败',
            2000103 => '微信公众号获取access_token失败',
            2000104 => '微信公众号获取用户信息失败',
            2000105 => 'ats通过openid查询WeixinSubscribeInfo无数据',
            2000106 => 'ats通过employee_id查询Employee无数据',
            2000107 => '微信公众号通过code获取access_token失败',
            2000108 => '微信公众号通过code获取用户信息失败',
            2000109 => 'employee信息不存在',
        ];
    }
}
