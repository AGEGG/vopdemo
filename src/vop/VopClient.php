<?php

namespace VopClient;

class VopClient
{
    public $gatewayUrl = "https://gw.vipapis.com/";
    public $format = "json";
    public $appkey;
    public $secretKey;
    public $sign;
    public $accessToken;
    public $language;

    public function __construct($appkey = "", $secretKey = "")
    {
        $this->appkey = $appkey;
        $this->secretKey = $secretKey;
    }

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


    public function execute($request, $replaceUrl = null)
    {
        $timestamp = round(self::currentTimeMillis()/1000);
        //系统参数
        $sysParams["appKey"] = $this->appkey;
        $sysParams["format"] = $this->format;
        $sysParams["method"] = $request->getApiMethodName();
        $sysParams["service"] = $request->getApiServiceName();
        $sysParams["timestamp"] = $timestamp;
        $sysParams["version"] = $request->getApiVersion();
        $sysParams["accessToken"] = $this->accessToken;
        $sysParams["language"] = $this->language;

        //业务参数
        $busiParams = json_encode($request->getApiParas());

        //签名
        $sysParams["sign"] = self::createRequestSign($sysParams["accessToken"], $sysParams["appKey"], $sysParams["format"], $sysParams["language"], $sysParams["method"], $sysParams["service"], $timestamp, $sysParams["version"], $busiParams, $this->secretKey);

        //拼接url
        if ($replaceUrl) {
            $requestUrl = $replaceUrl."?";
        } else {
            $requestUrl = $this->gatewayUrl."?";
        }
        foreach (array_filter($sysParams) as $sysParamKey => $sysParamValue) {
            $requestUrl .= "$sysParamKey=" . urlencode($sysParamValue) . "&";
        }
        $requestUrl = substr($requestUrl, 0, -1);

        $contentType = "";
        if (strtolower($this->format) == "json") {
            $contentType = "application/json;charset=utf-8";
        } else if (strtolower($this->format) == "xml") {
            $contentType = "application/xml;charset=utf-8";
        } else {
            exit("format只能为json或xml(不区分大小写)");
        }

        $opts = array (
            'http' => array(
                'method' => 'POST',
                'header' => "Content-type:". $contentType .
                    "Content-Length: " . strlen($busiParams) . "\r\n",
                'content' => $busiParams
            )
        );
        $context = stream_context_create($opts);
        $html = file_get_contents($requestUrl, false, $context);
        return json_decode($html, true);
    }
}
