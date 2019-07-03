<?php

namespace App\Providers;

use ApiRequest\ApiRequest;
use App\Exceptions\JsonException;
use Illuminate\Support\ServiceProvider;

class ApiRequestServiceProvider extends ServiceProvider
{
    /**
     * 显示是否延迟提供程序的加载
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * 在容器中注册绑定api通用请求插件
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ApiRequest', function () {
            return new ApiRequest(JsonException::class, app()->basePath() . '/config');
        });
    }

    /**
     * 获取提供者提供的服务
     *
     * @return array
     */
    public function provides()
    {
        return ['ApiRequest'];
    }
}
