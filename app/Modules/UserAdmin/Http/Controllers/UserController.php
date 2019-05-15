<?php

namespace App\Modules\UserAdmin\Http\Controllers;

use App\Common\Utils\LogUtils;
use App\Http\Controllers\Controller;
use App\Modules\UserAdmin\Services\UserService;
use Illuminate\Http\Request;
use App\Modules\YjjTest\Exception\EmployeeException;
use Validator;

class UserController extends Controller
{
    protected $userService;

    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    /**
     * 显示文章列表.
     *
     * @return Response
     */
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
}
