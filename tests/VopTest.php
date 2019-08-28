<?php

namespace Agegg\Vop\Tests;

use Mockery\Matcher\AnyArgs;
use PHPUnit\Framework\TestCase;
use Agegg\Vop\Common;
use Agegg\Vop\Vop;
use Agegg\Vop\GenByGoodsIdRequest;


class WeatherTest extends TestCase
{

    public function testDemo()
    {
        $this->assertSame(2, 1+1);
    }

    public function testLength()
    {
        $key = Common::createRequestSign(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
        $this->assertSame(32, strlen("$key"));
    }


    //call vendor/bin/phpunit --filter testReturnCode
    public function testReturnCode()
    {
        $vop = new Vop(config('services.vop.appKey'), config('services.vop.appSecret'));
        $info = new GenByGoodsIdRequest;
        $info->setChanTag('chanTag');
        $info->setRequestId('requestId');
        $info->setGoodsList(['6918179815364186628','6917925588049298498']);
        $resp = $vop->execute($info);
        $respArray = json_decode($resp, true);
        $this->assertSame('0', $respArray['returnCode']);

        $keyExists = array_key_exists('noEvokeUrl', json_decode($resp, true)['result']['urlInfoList'][0]);
        $this->assertSame(true, $keyExists);
    }
}
