<?php

namespace App\Common\Base;


use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Dingo\Api\Routing\Helpers;
use App\Common\Utils\ResultUtil;


/**
 * Class TobController
 *
 * @package App\Common\Base
 */
class TobController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Helpers;

    /**
     * TobController constructor.
     */
    public function __construct()
    {
    }


    /**
     * notes:
     * author: jianjun.yan
     * date: 2019-05-15 20:36
     *
     * @param null $data
     *
     * @return mixed
     */
    public function success($data = null)
    {
        return ResultUtil::success($data);
    }


    /**
     * notes: 暂时保存-返回数据列表
     * author: jianjun.yan
     * date: 2019-05-15 20:36
     *
     * @param      $list
     * @param null $pagination
     * @param null $head
     *
     * @return mixed
     */
    public function dataList($list, $pagination = null, $head = null)
    {
        $data = [
            'list' => $list
        ];
        if ($pagination) {
            $data['pagination'] = $pagination;
        }
        if ($head) {
            $data['head'] = $head;
        }
        return $this->success($data);
    }


    /**
     * notes: 失败返回
     * author: jianjun.yan
     * date: 2019-05-15 20:36
     *
     * @param     $msg
     * @param int $code
     *
     * @return mixed
     */
    public function failed($exception, $data = '')
    {
        $msg = $exception->getMessage();
        $code = $exception->getCode();
        return ResultUtil::failed($msg, $code, $data);
    }

}