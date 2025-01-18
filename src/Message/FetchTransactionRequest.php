<?php

namespace Omnipay\Montonio\Message;

use Montonio\Clients\AbstractClient;
use Montonio\Clients\PaymentsClient;
use Montonio\Exception\RequestException;

use Omnipay\Common\Exception\InvalidRequestException;

class FetchTransactionRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getData()
    {
        $this->validate( 'transactionId' );

        return [
            'transactionId' => $this->getTransactionId(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function sendData($data)
    {
        try {
            $client = new PaymentsClient($this->getAccessKey(), $this->getSecretKey(), $this->getTestMode() ? AbstractClient::ENVIRONMENT_SANDBOX : AbstractClient::ENVIRONMENT_LIVE);
            $response = $client->fetchOrder($data['transactionId']);

            return $this->response = new FetchTransactionResponse($this, $response);
        } catch (RequestException $e) {
            throw new InvalidRequestException('Request failed: ' . $e->getResponse(), $e->getCode(), $e);
        } catch (\Throwable $e) {
            throw new InvalidRequestException('Failed to request purchase: ' . $e->getMessage(), 0, $e);
        }
    }
}
