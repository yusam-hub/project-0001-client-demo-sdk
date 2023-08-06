<?php

namespace YusamHub\Project0001ClientDemoSdk\Tests;

use YusamHub\Project0001ClientDemoSdk\ClientDemoSdk;

class ClientDemoSdkTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $clientDemoSdk = new ClientDemoSdk(Config::getConfig('demo-sdk'));
        $home = $clientDemoSdk->getHome();
        $this->assertTrue(is_array($home));
    }
}