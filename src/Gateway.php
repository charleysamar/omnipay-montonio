<?php

namespace Omnipay\Montonio;

use Montonio\Clients\AbstractClient;
use Montonio\Clients\PaymentsClient;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Montonio\Message\PurchaseRequest;

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
     * @return AbstractRequest|PurchaseRequest
     */
    public function purchase(array $options = array())
    {
        return $this->createRequest('\Omnipay\Montonio\Message\PurchaseRequest', $options);
    }
}
