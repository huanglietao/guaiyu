<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * 测试api返回的数据结构与结果
     * author hxc
     * @param $response
     * @param int $code
     */
    public function apiStructure($response, $code=0)
    {
        $response->seeJson([
            'code' => $code,
        ])->seeJsonStructure([
            'code',
            'msg',
            'data'
        ]);
    }
}
