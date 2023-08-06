<?php

namespace YusamHub\Project0001ClientDemoSdk\Tests;

use YusamHub\Project0001ClientDemoSdk\ClientDemoSdk;

class ClientDemoSdkTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $clientDemoSdk = new ClientDemoSdk(Config::getConfig('demo-sdk'));
        $clientDemoSdk->setAccessToken('0f37370a3a6fb7140d170b797d81fda2');
        $v1Test = $clientDemoSdk->getApiV1Test();
        $this->assertTrue(is_array($v1Test));
    }
}