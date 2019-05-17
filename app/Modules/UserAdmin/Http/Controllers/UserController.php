<?php

namespace App\Modules\UserAdmin\Http\Controllers;

use App\Common\Base\TobController;
use App\Common\Utils\LogUtils;
use App\Modules\UserAdmin\Models\UserMenu;
use App\Modules\UserAdmin\Services\UserService;
use Illuminate\Http\Request;
use App\Modules\UserAdmin\Exception\UserAdminException;
use Validator;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends TobController
{
    protected $userService;

    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        try {
            var_dump($aaw);
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

    //@return Response
    public function getUserByEmail(Request $request, $email)
    {
        $input = $request->all();


        dd($input);
        try {
            //throw EmployeeException::error(2000104);
            $aa = date("Y/m/d H:i:s");
            //var_dump($aa);
            var_dump($aawww);
            $res = $this->userService->getUserByEmail($email);
            return $res;
        } catch (\Exception $e) {
            LogUtils::catch_error($e, $email);
            $arr = LogUtils::getThrowArr($e, $email);
            return \Response::make($arr, 500);
        }
    }

    public function show(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return \Response::make(['error' => $validator->errors()], 401);

        }
        LogUtils::info(__CLASS__ . '=>' . __FUNCTION__ . ': param=' . json_encode($input, JSON_UNESCAPED_UNICODE));
        var_dump(__CLASS__);
        var_dump(__FUNCTION__);

        //dd($request->has(['name', 'email']));
        if (!$request->has(['name', 'email'])) {
            //
            echo '不存在字段';
        }
        dd($input);
    }

    public function menu()
    {
        $aa = UserMenu::get();
        return $this->success($aa);

    }

    //使用案例
    public function ceshi()
    {
        try {
            $res = $this->userService->ceshi();
            var_dump($aaw);
            $success = ['success'];
            return $this->success($success);
        } catch (\Exception $e) {
            //是否记录异常日志
            LogUtils::catch_error($e,__METHOD__);
            return $this->failed($e);
        }
    }
}
