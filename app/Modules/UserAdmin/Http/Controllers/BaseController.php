<?php

namespace App\Modules\UserAdmin\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Common\Base\TobController;
use App\Modules\UserAdmin\Models\UserMenu;

/**
 * Class BaseController
 *
 * @package App\Modules\UserAdmin\Http\Controllers
 */
class BaseController extends TobController
{

    /**
     * api: /api/base/user-info
     *
     * notes:
     * author: jianjun.yan
     * date: 2019-05-21 15:51
     *
     * @param $id
     *
     * @return mixed
     */
    public function userInfo()
    {
        try {
            $user = Auth::user();
            return $this->success($user);
        } catch (\Exception $e) {
            return $this->failed($e);
        }
    }
    /**
     * api: /api/base/menu
     *
     * notes: 获取菜单列表-后续补充当前用户菜单权限
     * author: jianjun.yan
     * date: 2019-05-21 10:20
     *
     * @return mixed
     */
    public function menu()
    {
        $menuInfo = UserMenu::get('name')->map(function ($menuInfo) {
            return $menuInfo->name;
        });
        return $this->success($menuInfo);
        //查询一个字段作为一个一位数组-上下2种方式
//        $menuInfo = UserMenu::get('name')->toArray();
//        $menuInfoFiled = array_pluck($menuInfo, 'name');
//        return $this->success($menuInfoFiled);
    }
}
