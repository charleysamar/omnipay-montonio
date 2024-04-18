<?php

namespace Omnipay\Montonio\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * {@inheritDoc}
     */
    public function isSuccessful()
    {
        // Return false to indicate that more actions are needed to complete the transaction.
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function isRedirect()
    {
        return !empty($this->data['paymentUrl']);
    }

    /**
     * {@inheritDoc}
     */
    public function getRedirectUrl()
    {
        return $this->data['paymentUrl'];
    }

    /**
     * {@inheritDoc}
     */
    public function getRedirectMethod()
    {
        return 'POST';
    }

    /**
     * {@inheritDoc}
     */
    public function getRedirectData()
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getTransactionReference()
    {
        return $this->data['uuid'];
    }
}
