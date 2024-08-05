<?php

namespace Omnipay\Montonio\Tests\Message;

use Montonio\Structs\Payment;
use Omnipay\Montonio\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'accessKey' => 'access-key',
            'secretKey' => 'secret-key',
            'paymentMethod' => Payment::PAYMENT_METHOD_PAYMENT_INITIATION,
            'preferredCountry' => '',
            'preferredProvider' => '',
            'testMode' => false,
            'transactionId' => '',
            'sellerId' => 'seller-id',
            'amount' => 100,
            'currency' => 'EUR',
            'description' => 'description',
            'returnUrl' => 'return-url',
            'cancelUrl' => 'cancel-url',
            'notifyUrl' => 'notify-url',
        ]);
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertNotEmpty($data->getMerchantReference());
        $this->assertSame('access-key', $data->getAccessKey());
        $this->assertSame('return-url', $data->getReturnUrl());
        $this->assertSame('notify-url', $data->getNotificationUrl());
        $this->assertSame(10000.0, $data->getGrandTotal());
        $this->assertSame('EUR', $data->getCurrency());
        $this->assertSame(Payment::PAYMENT_METHOD_PAYMENT_INITIATION, $data->getPayment()->getMethod());
        $this->assertSame(10000.0, $data->getPayment()->getAmount());
        $this->assertSame('EUR', $data->getPayment()->getCurrency());
        $this->assertSame('description', $data->getPayment()->getMethodOptions()->getPaymentDescription());
    }
}
