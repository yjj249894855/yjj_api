<?php

namespace App\Modules\UserAdmin\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Base\TobController;
use App\Common\Base\TopConfig;
use App\Common\Utils\LogUtils;
use App\Modules\UserAdmin\Models\UserMenu;
use App\Modules\UserAdmin\Services\UserService;
use App\Modules\UserAdmin\Exception\UserAdminException;
use Validator;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends TobController
{

    public function index(Request $request)
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
//        $menuInfo = User::get();
//        $sorted = $menuInfo->sortByDesc('id');
//        $sorted->values()->all();
//        $sorted = $sorted->toArray();
//        $sorted = array_values($sorted);
//        return $this->success($menuInfo);
        return $this->success($menuInfo);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = Auth::user();
            return $this->success($user);
        } catch (\Exception $e) {
            return $this->failed($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
