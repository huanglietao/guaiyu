<?php
/**
 * 功能：公共方法
 */
namespace App\Http\Common;

use App\Exceptions\JsonException;
use App\Exceptions\ApiException;

class Helper
{
    /**
     * 功能：过滤一维数组NULL值
     * author hxc
     * @param $data
     * @return array
     */
    public static function filterNull($data)
    {
        return array_filter($data, function ($v) {
            return $v !== null;
        });
    }

    /*
     * curl_get提交方式
     * @param string $url 请求链接
     * @oaram int $req_number 失败请求次数
     * @param int $timeout 请求时间
     *
     */
    public static function curlGet($url, $req_number = 2, $timeout = 30)
    {

        //防止因网络原因而高层无法获取
        $cnt = 0;
        $result = false;
        while ($cnt < $req_number && $result === false) {
            $cnt++;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            //禁止直接显示获取的内容 重要
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //在发起连接前等待的时间，如果设置为0，则无限等待。
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            //不验证证书下同
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //SSL验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $result = curl_exec($ch); //获取
            curl_close($ch);
        }//end func curl_get

        //获取数据
        $data = $result ? $result : null;

        return $data;
    }//end func curlGet

    /**
     * curl_get提交方式
     * @param string $url 请求链接
     * @param array $post_data 请求数据
     * @param string $post_type 请求类型(json)
     *
     */
    public static function curlPost($url, $post_data = '', $post_type = '', $curl_params = [])
    {
        //初始化curl
        $ch = curl_init();
        //设置请求地址
        curl_setopt($ch, CURLOPT_URL, $url);
        //设置curl参数，要求结果是否输出到屏幕上，为true的时候是不返回到网页中
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //https ssl 验证
        if (!empty($curl_params['ssl'])) {
            $ssl = $curl_params['ssl'];
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); //验证站点名
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); // 只信任CA颁布的证书
            if (!empty($ssl['sslca'])) {
                curl_setopt($ch, CURLOPT_CAINFO, $ssl['sslca']);
            }
            if (!empty($ssl['sslcert'])) {
                curl_setopt($ch, CURLOPT_SSLCERT, $ssl['sslcert']);
            }
            if ($ssl['sslkey']) {
                curl_setopt($ch, CURLOPT_SSLKEY, $ssl['sslkey']);
            }
        } else {
            //验证站点名
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            //是否验证https(当请求链接为https时自动验证，强制为false)
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 只信任CA颁布的证书
        }

        //设置post提交方式
        curl_setopt($ch, CURLOPT_POST, 1);
        //设置post字段
        $post_data = is_array($post_data) ? http_build_query($post_data) : $post_data;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        //判断是否json提交
        if ('json' == $post_type) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Expect:',
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($post_data)
            ));
        }

        //运行curl
        $output = curl_exec($ch);
        //关闭curl
        curl_close($ch);
        //返回结果
        return $output;
    }//end func curlPost

    /**
     * 更新拼装
     * $multipleData = [{"id":7,"sort":1},{"id":8,"sort":1}];
     * author hxc
     * @param $tables
     * @param array $multiple_data
     * @return bool|string
     */
    public static function updateBatch($tables, $multiple_data = array())
    {

        if (!empty($multiple_data)) {
            // column or fields to update
            $update_column = array_keys($multiple_data[0]);
            $reference_column = $update_column[0]; //e.g id
            unset($update_column[0]);
            $where_in = "";
            $q = "UPDATE " . $tables . " SET ";
            foreach ($update_column as $u_column) {
                $q .= $u_column . " = CASE ";

                foreach ($multiple_data as $data) {
                    $q .= "WHEN " . $reference_column . " = " . $data[$reference_column] . " THEN '" . $data[$u_column] . "' ";
                }
                $q .= "ELSE " . $u_column . " END, ";
            }
            foreach ($multiple_data as $data) {
                $where_in .= "'" . $data[$reference_column] . "', ";
            }
            $q = rtrim($q, ", ") . " WHERE " . $reference_column . " IN (" . rtrim($where_in, ', ') . ")";
            return $q;
        } else {
            return false;
        }
    }

    /**
     * 校验接口返回是否正常，仅仅是对用内部项目的 code 是否为0判断！
     * author hxc
     * @param $api_data
     * @return mixed
     */
    public static function checkApiResponse($api_data)
    {
        if (!is_array($api_data)) {
            throw new JsonException(100001);
        }

        if (!isset($api_data['code']) || !isset($api_data['data'])) {
            throw new JsonException(100003);
        }

        if ($api_data['code'] != 0) {
            app('Logger')->info('api请求返回错误', $api_data);
            throw new ApiException($api_data);
        }

        return $api_data['data'];
    }

    /**
     * 过滤字符串 && 数字 && 数组 && 对象的空格
     * @author  hxc
     * @param   需要过滤的数据
     * @param   $charlist = " \t\n\r\0\x0B",过滤的模式
     * @notic   支持多维
     */
    public static function trimAny(&$data, $charlist = " \t\n\r\0\x0B")
    {
        if (is_array($data) || is_object($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    $data[$key] = self::trimAny($value, $charlist);
                } else {
                    $data[$key] = self::trimAny($value, $charlist);
                }
            }
        } else {
            if (is_string($data)) {
                $data = trim($data, $charlist);
            }
        }
        return $data;
    }
}
