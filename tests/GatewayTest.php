<?php

namespace Omnipay\Montonio\Tests;

use Omnipay\Montonio\Gateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var Gateway
     */
    public $gateway;

    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setAccessKey('access-key');
        $this->gateway->setTestMode(true);
    }

    public function testGateway()
    {
        $this->assertSame('access-key', $this->gateway->getAccessKey());
        $this->assertTrue($this->gateway->getTestMode());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase();
        $this->assertInstanceOf('Omnipay\Montonio\Message\PurchaseRequest', $request);
    }

    public function testCompletePurchase()
    {
        $request = $this->gateway->completePurchase();
        $this->assertInstanceOf('Omnipay\Montonio\Message\CompletePurchaseRequest', $request);
    }
}
