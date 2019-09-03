<?php

namespace VopClient\request;

class GenByVIPUrlRequest
{
    private $apiParas = array();

    private $version = "1.0.0";

    public function setUrlList($urlList)
    {
        $this->apiParas["urlList"] = $urlList;
    }

    public function setChanTag($chanTag)
    {
        $this->apiParas["chanTag"] = $chanTag;
    }

    public function setRequestId($requestId)
    {
        $this->apiParas["requestId"] = $requestId;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getApiVersion()
    {
        return $this->version;
    }

    public function getApiMethodName()
    {
        return "genByVIPUrl";
    }

    public function getApiServiceName()
    {
        return "com.vip.adp.api.open.service.UnionUrlService";
    }

    public function getApiParas()
    {
        return $this->apiParas;
    }
}
