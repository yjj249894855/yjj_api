<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class EnableCrossRequestMiddleware
 *
 * @package App\Http\Middleware
 */
class EnableCrossRequestMiddleware
{

    /**
     * notes: 跨域中间件-单独创建
     * author: jianjun.yan
     * date: 2019-05-16 20:27
     *
     * @param         $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $origin = $request->server('HTTP_ORIGIN') ? $request->server('HTTP_ORIGIN') : '';
        $allow_origin = [
            'http://localhost:8082',//允许访问
        ];
        if (in_array($origin, $allow_origin)) {
            $response->header('Access-Control-Allow-Origin', $origin);
            $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN');
            $response->header('Access-Control-Expose-Headers', 'Authorization, authenticated');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT, OPTIONS');
            $response->header('Access-Control-Allow-Credentials', 'true');
        }
        return $response;
    }
}
