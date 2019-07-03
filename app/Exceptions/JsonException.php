<?php

namespace App\Exceptions;

use Exception;

class JsonException extends Exception
{
    /**
     * 错误码列表
     * 10000 - 19999 基本错误
     */
    private $code_list = [
        '10000' => [
            'msg' => '参数错误',
        ],
        '10001' => [
            'msg' => '参数非法',
        ],
        '10100'   =>  [
            'msg'   =>  '加密参数异常!',
            'status_code'   =>  403
        ],
        '10110'   =>  [
            'msg'   =>  '加密校验失败!',
        ],
        /*---基本错误 start-----*/

        /** 数据库操作 start **/
        '11000' => [
            'msg' => '数据记录不存在',
        ],
        '11001' => [
            'msg' => '保存到数据库失败',
        ],
        '11002' => [
            'msg' => '更新到数据库失败',
        ],
        '11003' => [
            'msg' => '从数据库删除失败',
        ],
        '11004' => [
            'msg' => '事务执行失败'
        ],
        /** 数据库操作 end **/
        '20000' => [
            'msg' => '用户未登陆',
        ],
        '20001' => [
            'msg' => '用户名已经存在',
        ],
        '20002' => [
            'msg' => '用户邮箱已经存在',
        ],
        /** 数据库操作 end **/
        //请求专用,方便之后迁移到包
        '100000'   =>  [
            'msg'   =>  '获取接口地址失败!'
        ],
        '100001'  =>  [
            'msg'   =>  '请求接口失败,无法请求接口!',
        ],
        '100002'  =>  [
            'msg'   =>  '请求接口异常，接口非正常响应!',
        ],
        '100003'  =>  [
            'msg'   =>  '接口返回数据参数异常!',
        ],



    ];


    /**
     * 构造函数
     */
    public function __construct($code, $data = [])
    {

        $this->code = $code;
        $this->data = $data;
    }


    /**
     * 获取错误信息
     */
    public function getErrorMsg()
    {

        if (is_array($this->code)) {
            return $this->code;
        }

        $re = [
            'code' => 10000,
            'msg'  => $this->code_list[10000]['msg'],
            'data' => is_numeric($this->code) ? '' : $this->code,
            'module'    =>  config('site.module_name'),
        ];
        if (empty($this->code_list[$this->code])) {
            return $re;
        }

        $re['code'] = (string)$this->code;
        $re['msg']  = $this->code_list[$this->code]['msg'];
        $re['data'] = $this->data;
        $re['module'] = config('site.module_name');

        return $re;
    }
}
