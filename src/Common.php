<?php
namespace Agegg\Vop;

class Common
{
    /**
     * 基于md5的加密算法hmac
     *
     * md5已经不是那么安全了，多折腾几下吧
     *
     * @param String $data 预加密数据
     * @param String $key  密钥
     * @return String
    */

    public static function hmac($data, $key)
    {
        if (function_exists('hash_hmac')) {
            return strtoupper(hash_hmac('md5', $data, $key));
        }

        $key = (strlen($key) > 64) ? pack('H32', 'md5') : str_pad($key, 64, chr(0));
        $ipad = substr($key, 0, 64) ^ str_repeat(chr(0x36), 64);
        $opad = substr($key, 0, 64) ^ str_repeat(chr(0x5C), 64);
        return strtoupper(md5($opad.pack('H32', md5($ipad.$data))));
    }

    public static function currentTimeMillis()
    {
        list($t1, $t2) = explode(' ', microtime());
        return (float) (floatval($t1) + floatval($t2)) * 1000;
    }

    public static function currentTimeStamp()
    {
        list($usec, $sec) = explode(' ', microtime());
        $d1 = strftime("%Y-%m-%d %H:%M:%S", $sec);
        $d2 = (int)($usec * 1000);
        $result = $d1 . "." . sprintf("%03d", $d2);
        return $result;
    }


    public static function createRequestSign($accessToken, $appKey, $format, $language, $method, $service, $timestamp, $version, $busiParams, $appSecret)
    {
        $sign = '';
        if (!empty($accessToken)) {
            $sign .= "accessToken" . $accessToken;
        }
        $sign .= "appKey" . $appKey;
        $sign .= "format" . $format;
        if (!empty($language)) {
            $sign .= "language" . $language;
        }
        $sign .= "method" . $method;
        $sign .= "service" . $service;
        $sign .= "timestamp" . $timestamp;
        $sign .= "version" . $version;
        $sign .= $busiParams;
        // var_dump("这里是拼接后的字符串：". $sign);
        return self::hmac($sign, $appSecret);
    }

    /**
     * 组装请求参数
     * @param unknown $request
     * @return string
     */
    public static function getQueryString($request)
    {
        $params = '';
        $params = $params . "appKey=" . $request["appKey"];
        $params = $params . "&format=" . $request["format"];
        $params = $params . "&method=" . $request["method"];
        $params = $params . "&service=" . $request["service"];
        $params = $params . "&sign=" . $request["sign"];
        $params = $params . "&timestamp=" . $request["timestamp"];
        $params = $params . "&version=" . $request["version"];
        if (!empty($request["accessToken"])) {
            $params = $params . "&accessToken=" . $request["accessToken"];
        }
        if (!empty($request["language"])) {
            $params = $params . "&language=" . $request["language"];
        }

        return $params;
    }
}
