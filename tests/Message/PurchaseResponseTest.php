<?php

namespace Omnipay\Montonio\Tests\Message;

use Omnipay\Montonio\Message\PurchaseRequest;
use Omnipay\Montonio\Message\PurchaseResponse;
use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    protected $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testRedirect()
    {
        $response = new PurchaseResponse(
            $this->request,
            [
                'uuid' => 'payment-uuid',
                'paymentUrl' => 'redirect-url'
            ]
        );

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isCancelled());
        $this->assertFalse($response->isPending());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertNull($response->getTransactionId());
        $this->assertSame('payment-uuid', $response->getTransactionReference());
        $this->assertEmpty($response->getRedirectData());
    }
}
