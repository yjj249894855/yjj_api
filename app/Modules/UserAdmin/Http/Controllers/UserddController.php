<?php

namespace App\Modules\UserAdmin\Http\Controllers;

use App\Common\Base\TobController;
use App\Common\Base\TopConfig;
use App\Common\Utils\LogUtils;
use App\Modules\UserAdmin\Models\UserMenu;
use App\Modules\UserAdmin\Services\UserService;
use Illuminate\Http\Request;
use App\Modules\UserAdmin\Exception\UserAdminException;
use Validator;
use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 *
 * @package App\Modules\UserAdmin\Http\Controllers
 */
class UserddController extends TobController
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }




    /**
     * notes: 获取用户信息
     * author: jianjun.yan
     * date: 2019-05-17 17:31
     *
     * @return mixed
     */
    public function getUserInfo()
    {
        try {
            $user = Auth::user();
            return $this->success($user);
        } catch (\Exception $e) {
            return $this->failed($e);
        }
    }

    public function list(Request $request)
    {
        $where = [];
        if ($request->get('name')) {
            $where['name'] = $request->get('name');
        }
        if ($request->get('email')) {
            $where['email'] = $request->get('email');
        }
        $limit = TopConfig::PAGE_LIMIT;
        if ($request->get('limit')) {
            $limit = $request->get('limit');
        }
        $menuInfo = User::where($where)->orderBy('id', 'desc')->paginate($limit);

        //$menuInfo = User::orderBy('id', 'desc')->get()->toArray();

//        $menuInfo = User::get();
//        $sorted = $menuInfo->sortByDesc('id');
//        $sorted->values()->all();
//        $sorted = $sorted->toArray();
//        $sorted = array_values($sorted);
//        return $this->success($menuInfo);
        return $this->success($menuInfo);
    }

    /**
     * notes:
     * author: jianjun.yan
     * date: 2019-05-17 17:30
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * notes: 获取菜单列表-后续补充当前用户菜单权限
     * author: jianjun.yan
     * date: 2019-05-17 17:30
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

    //使用案例

    /**
     * notes: 测试
     * author: jianjun.yan
     * date: 2019-05-17 17:30
     *
     * @return mixed
     */
    public function ceshi()
    {
        try {
            $res = $this->userService->ceshi();
            var_dump($aaw);
            $success = ['success'];
            return $this->success($success);
        } catch (\Exception $e) {
            //是否记录异常日志
            LogUtils::catch_error($e, __METHOD__);
            return $this->failed($e);
        }
    }
}
