<?php
namespace Agegg\Vop;

class GenByGoodsIdRequest
{
    public $chanTag;
    public $requestId;
    public $goodsIdList;

    public function __construct()
    {
        $this->chanTag = 'chanTag';
        $this->requestId = 'requestId';
        $this->goodsIdList = '';
    }

    public function setChanTag($chanTag)
    {
        $this->chanTag = $chanTag;
    }

    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }

    public function setGoodsList($goodsIdList)
    {
        $this->goodsIdList = $goodsIdList;
    }
}
