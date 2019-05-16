<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 将所有的 Exception 全部交给 App\Exceptions\Handler 来处理
        app('api.exception')->register(function (\Exception $exception) {
            $request = Request::capture();
            return app('App\Exceptions\Handler')->render($request, $exception);
        });
    }
}
