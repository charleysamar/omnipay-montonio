<?php

namespace Omnipay\Montonio\Message;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Omnipay\Common\Exception\InvalidRequestException;

class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $data = $this->httpRequest->query->all();

        if (!isset($data['order-token'])) {
            throw new InvalidRequestException('missing order token');
        }

        return array(
            'order_token' => $data['order-token'],
        );
    }

    /**
     * @param array $data
     *
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        try {
            // Add a bit of leeway to the token expiration time
            JWT::$leeway = 60 * 5; // 5 minutes

            // verify and decode data
            $response = JWT::decode($data['order_token'], new Key($this->getSecretKey(), 'HS256'));

            // convert to array
            $response = json_decode(json_encode($response), true);

            if (empty($response)) {
                throw new \Exception('empty data');
            }

            if (empty($response['merchantReference'])) {
                throw new \Exception('missing merchant reference');
            }

            return $this->response = new CompletePurchaseResponse($this, $response);
        } catch (\Throwable $e) {
            throw new InvalidRequestException('complete purchase failed', $e->getCode(), $e);
        }
    }
}
