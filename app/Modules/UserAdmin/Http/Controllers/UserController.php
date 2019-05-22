<?php

namespace App\Modules\UserAdmin\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Base\TobController;
use App\Common\Base\TopConfig;
use App\Common\Utils\LogUtils;
use App\Modules\UserAdmin\Models\User;
use App\Modules\UserAdmin\Services\UserService;
use App\Modules\UserAdmin\Exception\UserAdminException;


/**
 * Class UserController
 *
 * @package App\Modules\UserAdmin\Http\Controllers
 */
class UserController extends TobController
{

    /**
     * notes:
     * author: jianjun.yan
     * date: 2019-05-21 16:01
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $where['is_delete'] = TopConfig::IS_NOT_DELETED;
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
     * date: 2019-05-21 16:02
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * notes:
     * author: jianjun.yan
     * date: 2019-05-21 16:01
     *
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        try {
            $user = User::where(['id' => $id])->first();
            return $this->success($user);
        } catch (\Exception $e) {
            return $this->failed($e);
        }
    }


    /**
     * notes:
     * author: jianjun.yan
     * date: 2019-05-22 10:28
     *
     * @param Request $request
     * @param         $id
     *
     * @throws \App\Common\Base\TobException
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $user = User::where(['id' => $id])->first();
        if (empty($user)) {
            throw UserAdminException::error(1001001);
        }else{
            $user->name = $request->get('name');
            $user->save();
        }
        return $this->success('success');
    }

    /**
     * notes:
     * author: jianjun.yan
     * date: 2019-05-22 09:47
     *
     * @param $id
     *
     * @throws \App\Common\Base\TobException
     * @return mixed
     */
    public function destroy($id)
    {
        $user = User::where(['id' => $id])->first();
        if (empty($user)) {
            throw UserAdminException::error(1001001);
        } else {
            $user->is_delete = TopConfig::IS_DELETED;
            $user->save();
        }
        return $this->success('success');
    }

}
