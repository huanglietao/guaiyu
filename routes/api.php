<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, Access-Control-Allow-Headers, X-Requested-With');
header('Access-Control-Allow-Methods: *');

$router->group([], function () use ($router) {
    //需要加密的
    $middleware = [];
    if (config('app.env') != 'local') {
        $middleware[] = 'checkSign';
    }
    //课程
    $router->group(['prefix' => 'V1'], function($router)
    {
        //用户模块
        $router->group(['prefix' => 'users'], function ($app)
        {
            //用户注册
            $app->post('register', 'UsersController@register');
            //获取信息用户信息
            $app->get('me', ['uses' => 'UsersController@me','middleware' => 'auth']);

            # 模拟用户注册路由
            //$app->post('register', 'ClientController@register');
            # 模拟登录私人访问的客户端
            $app->post('loginPersonalClient', 'ClientController@loginPersonalClient');
            # 模拟添加使用密码认证的客户端
            $app->post('registerPasswordClient', 'ClientController@registerPasswordClient');
            # 模拟添加私人访问的客户端
            $app->post('registerPersonalClient', 'ClientController@registerPersonalClient');
        });
        //课程
        $router->group(['prefix' => 'course'], function($app)
        {
            //获取列表
            $app->get('/', 'CourseController@index');
            //获取详情
            $app->get('/{id}', 'CourseController@show');





        });
    });

});

