<?php

namespace App\Modules\UserAdmin\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Base\TobController;
use App\Common\Utils\LogUtils;
use App\Modules\UserAdmin\Exception\UserAdminException;

/**
 * Class MainController
 *
 * @package App\Modules\UserAdmin\Http\Controllers
 */
class MainController extends TobController
{

    /**
     * api: /api/main/logout
     *
     * notes: 登录接口
     * author: jianjun.yan
     * date: 2019-05-17 17:30
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function login(Request $request)
    {
        try {
            if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
                $user = Auth::user();
                $success['token'] = $user->createToken('MyApp')->accessToken;
            } else {
                throw UserAdminException::error(1001001);
            }
            return $this->success($success);
        } catch (\Exception $e) {
            //是否记录异常日志
            LogUtils::catch_error($e);
            return $this->failed($e);
        }

    }

    /**
     * api: /api/main/logout
     *
     * notes: 退出接口-后续补充退出处理token
     * author: jianjun.yan
     * date: 2019-05-17 17:33
     *
     * @return mixed
     */
    public function logout()
    {
        $success = 'success';
        return $this->success($success);
    }
}
