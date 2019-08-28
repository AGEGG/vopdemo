<?php
namespace Agegg\Vop;

use Agegg\Vop\Common;
use Agegg\Vop\Exceptions;

class Vop
{

    protected static $appKey;
    protected static $appSecret;

    public function __construct($appKey = '', $appSecret = '')
    {
        self::$appKey = $appKey;
        self::$appSecret = $appSecret;
    }


    public static function execute($req)
    {
        try {
            //系统级参数变量赋值
            $service = "com.vip.adp.api.open.service.UnionUrlService";
            $method = "genByGoodsId";
            $format = "json";
            $appKey = self::$appKey;
            $appSecret = self::$appSecret;
            $version = "1.0.0";
            $accessToken = null;
            $language = null;


            //业务级参数变量赋值
            // $busiParams = "{'goodsIdList':['6918179815364186628','6917925588049298498'],'chanTag':'chanTag','requestId':'requestId'}";
            $body = json_encode($req);
            $busiParams = "{$body}";

            // var_dump("业务级参数变量赋值".$busiParams);

            //当前时间戳
            $timestamp = round(Common::currentTimeMillis()/1000);

            $sysParams = array();
            $sysParams["service"] = $service;
            $sysParams["method"] = $method;
            $sysParams["version"] = $version;
            $sysParams["timestamp"] = $timestamp;
            $sysParams["format"] = $format;
            $sysParams["appKey"] = $appKey;

            //获取签名
            $sign = Common::createRequestSign($accessToken, $appKey, $format, $language, $method, $service, $timestamp, $version, $busiParams, $appSecret);
            // var_dump("这是签名好的结果值sign：". $sign."时间戳:".$timestamp);

            $sysParams["sign"] = $sign;

            $contentType = "";
            if (strtolower($format) == "json") {
                $contentType = "application/json;charset=utf-8";
            } elseif (strtolower($format) == "xml") {
                $contentType = "application/xml;charset=utf-8";
            } else {
                var_dump("format只能为json或xml(不区分大小写)");
                return;
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


            $html = file_get_contents('https://gw.vipapis.com/?'. Common::getQueryString($sysParams), false, $context);
            return $html;

        } catch (\Exception $e) {
            var_dump($e);
        }
    }
}
