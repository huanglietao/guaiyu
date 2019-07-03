<?php

$router->group([], function () use ($router) {
    //需要加密的
    $middleware = [];
    //课程
    $router->group(['prefix' => 'V1'], function($router)
    {
        //课程
        $router->group(['prefix' => 'course'], function($app)
        {
            //保存
            $app->post('/create', 'CourseController@create');
            //获取列表
            $app->get('/', 'CourseController@index');
            //获取详情
            $app->get('/{id}', 'CourseController@show');
            //更新
            $app->put('/{id}', 'CourseController@update');
            //删除
            $app->delete('/{id}', 'CourseController@destroy');

        });
    });

});

