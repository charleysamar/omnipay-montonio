<?php

namespace Omnipay\Montonio;

use Montonio\Clients\AbstractClient;
use Montonio\Clients\PaymentsClient;
use Montonio\Structs\Payment;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class Gateway
 * @package Omnipay\Montonio
 * @link https://docs.montonio.com
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Montonio';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'accessKey' => '',
            'secretKey' => '',
            'paymentMethod' => Payment::PAYMENT_METHOD_PAYMENT_INITIATION,
            'preferredCountry' => '',
            'preferredProvider' => '',
            'testMode' => false
        );
    }

    /**
     * Get access key.
     *
     * @return string access key
     */
    public function getAccessKey()
    {
        return $this->getParameter('accessKey');
    }

    /**
     * Set access key.
     *
     * @param string $value access key
     *
     * @return $this
     */
    public function setAccessKey($value)
    {
        return $this->setParameter('accessKey', $value);
    }

    /**
     * Get secret key.
     *
     * @return string secret key
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * Set secret key.
     *
     * @param string $value secret key
     *
     * @return $this
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    /**
     * Get payment method.
     *
     * @return string payment method
     */
    public function getPaymentMethod()
    {
        return $this->getParameter('paymentMethod');
    }

    /**
     * Set payment method.
     *
     * @param string $value payment method
     *
     * @return $this
     */
    public function setPaymentMethod($value)
    {
        return $this->setParameter('paymentMethod', $value);
    }

    /**
     * Get preferred country.
     *
     * @return string preferred country
     */
    public function getPreferredCountry()
    {
        return $this->getParameter('preferredCountry');
    }

    /**
     * Set preferred country.
     *
     * @param string $value preferred country
     *
     * @return $this
     */
    public function setPreferredCountry($value)
    {
        return $this->setParameter('preferredCountry', $value);
    }

    /**
     * Get preferred provider.
     *
     * @return string preferred provider
     */
    public function getPreferredProvider()
    {
        return $this->getParameter('preferredProvider');
    }

    /**
     * Set preferred provider.
     *
     * @param string $value preferred provider
     *
     * @return $this
     */
    public function setPreferredProvider($value)
    {
        return $this->setParameter('preferredProvider', $value);
    }

    /**
     * Get the list of available payment methods.
     *
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getPaymentMethods()
    {
        try {
            $client = new PaymentsClient($this->getAccessKey(), $this->getSecretKey(), $this->getTestMode() ? AbstractClient::ENVIRONMENT_SANDBOX : AbstractClient::ENVIRONMENT_LIVE);
            return $client->getPaymentMethods();
        } catch (\Throwable $e) {
            throw new InvalidRequestException('Failed to request payment mero: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * @param array $options
     *
     * @return AbstractRequest|RequestInterface
     */
    public function purchase(array $options = array())
    {
        return $this->createRequest('\Omnipay\Montonio\Message\PurchaseRequest', $options);
    }

    /**
     * @param array $options
     * @return AbstractRequest|RequestInterface
     */
    public function completePurchase(array $options = [])
    {
        return $this->createRequest('\Omnipay\Montonio\Message\CompletePurchaseRequest', $options);
    }

    /**
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest|FetchTransactionRequest
     */
    public function fetchTransaction(array $options = [])
    {
        return $this->createRequest('\Omnipay\Montonio\Message\FetchTransactionRequest', $options);
    }

    /**
     * Get period.
     *
     * @return int period
     */
    public function getPeriod()
    {
        return $this->getParameter('period') ?? 0;
    }

    /**
     * Set period.
     *
     * @param int $value period
     *
     * @return $this
     */
    public function setPeriod($value)
    {
        return $this->setParameter('period', $value);
    }

}
