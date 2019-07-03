<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //
    /**
     * 功能：return json data
     * author hxc
     * @param $data
     * @return array
     */
    public function jsonFormat($data)
    {
        if (is_object($data)) {
            if (method_exists($data, 'toArray')) {
                $data = $data->toArray();
            }
        }

        if (!is_array($data)) {
            $data = (array)$data;
        }

        if (isset($data['code']) && isset($data['data'])) {
            return $data;
        }

        return [
            'code' => 0,
            'msg'  => '成功',
            'data' => $data,
        ];
    }
}
