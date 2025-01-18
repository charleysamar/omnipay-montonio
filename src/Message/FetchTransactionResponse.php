<?php

namespace Omnipay\Montonio\Message;

use Omnipay\Common\Message\AbstractResponse;

class FetchTransactionResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getStatus() == 'PAID';
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->getStatus() == 'PENDING';
    }

    /**
     * @return bool
     */
    public function isCancelled()
    {
        return $this->getStatus() == 'VOIDED';
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->data['paymentStatus'] ?? null;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->data['uuid'] ?? null;
    }

    /**
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->data['merchantReference'] ?? null;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->getStatus();
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return null;
    }

}
