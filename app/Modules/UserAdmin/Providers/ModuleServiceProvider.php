<?php

namespace App\Modules\UserAdmin\Providers;

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
        $this->loadTranslationsFrom(module_path('UserAdmin', 'Resources/Lang', 'app'), 'UserAdmin');
        $this->loadViewsFrom(module_path('UserAdmin', 'Resources/Views', 'app'), 'UserAdmin');
        $this->loadMigrationsFrom(module_path('UserAdmin', 'Database/Migrations', 'app'), 'UserAdmin');
        $this->loadConfigsFrom(module_path('UserAdmin', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('UserAdmin', 'Database/Factories', 'app'));
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
