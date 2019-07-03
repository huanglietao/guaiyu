<?php

namespace App\Providers;

use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        LumenPassport::routes($this->app); # 注册Passport相关路由
        LumenPassport::allowMultipleTokens(); # 允许生成多个有效Token
    }
}
