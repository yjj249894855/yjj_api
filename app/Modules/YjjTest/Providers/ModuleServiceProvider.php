<?php

namespace App\Modules\YjjTest\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('YjjTest', 'Resources/Lang', 'app'), 'YjjTest');
        $this->loadViewsFrom(module_path('YjjTest', 'Resources/Views', 'app'), 'YjjTest');
        $this->loadMigrationsFrom(module_path('YjjTest', 'Database/Migrations', 'app'), 'YjjTest');
        $this->loadConfigsFrom(module_path('YjjTest', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('YjjTest', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
