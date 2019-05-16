<?php

namespace App\Providers;

use App\Common\Support\DbCounter;

use App\Common\Utils\CommonUtil;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Common\Events\Event' => [
            'App\Common\Listeners\EventListener'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //2019年05月15日21:50:32 jianjun.yan 补充监听sql
        if (CommonUtil::checkDebug()) {
            // 记录所有db执行sql
            \DB::listen(
                function ($sql) {
                    $i = 0;
                    $bindings = $sql->bindings;
                    $rawSql = preg_replace_callback('/\?/',
                        function ($matches) use ($bindings, &$i) {
                            $item = isset($bindings[$i]) ? $bindings[$i] : $matches[0];
                            $i++;
                            return gettype($item) == 'string' ? "'$item'" : $item;
                        }, $sql->sql);
                    //Log::debug($rawSql);-暂定-日志记录执行sql
                    DbCounter::logSql($rawSql);
                });
        }
    }
}
