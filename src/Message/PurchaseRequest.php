<?php

namespace Omnipay\Montonio\Message;

use Montonio\Clients\AbstractClient;
use Montonio\Clients\PaymentsClient;
use Montonio\Exception\RequestException;
use Montonio\Structs\Address;
use Montonio\Structs\LineItem;
use Montonio\Structs\Payment;
use Montonio\Structs\PaymentData;
use Montonio\Structs\PaymentMethodOptions;
use Montonio\Utils;

use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getData()
    {
        $this->validate(
            'transactionId',
            'amount',
            'currency',
            'description',
            'returnUrl',
            'cancelUrl',
            'notifyUrl'
        );

        $payment = (new PaymentData())
            ->setAccessKey($this->getAccessKey())
            ->setMerchantReference(uniqid())
            ->setReturnUrl($this->getReturnUrl())
            ->setNotificationUrl($this->getNotifyUrl())
            ->setCurrency($this->getCurrency())
            ->setGrandTotal($this->getAmountInteger())
            ->setLocale(Utils::getNormalizedLocale($this->getLanguage()));

        $items = $this->getItems();

        if (!empty($items)) {
            $payment->setLineItems(array_map(
                function ($item) {
                    /** @var \Omnipay\Common\Item $item */
                    $lineItem = new LineItem();

                    $lineItem->setName(trim(sprintf("%s %s", $item->getName(), $item->getDescription())))
                        ->setQuantity($item->getQuantity())
                        ->setFinalPrice($item->getPrice());

                    return $lineItem;
                },
                $items->all()
            ));
        }

        $payment->setPayment(
            (new Payment())
                ->setMethod($this->getPaymentMethod())
                ->setCurrency($this->getCurrency())
                ->setAmount($this->getAmountInteger())
                ->setMethodOptions(
                    (new PaymentMethodOptions())
                        ->setPaymentDescription($this->getDescription())
                        ->setPaymentReference($this->getTransactionId())
                        ->setPreferredCountry($this->getPreferredCountry())
                        ->setPreferredProvider($this->getPreferredProvider())
                        ->setPreferredLocale(Utils::getNormalizedLocale($this->getLanguage()))
                )
        );

        $card = $this->getCard();

        if (empty($card)) {
            return $payment;
        }

        if (!empty($card->getBillingAddress1())) {
            $billingAddress = (new Address())
                ->setFirstName($card->getFirstName())
                ->setLastName($card->getLastName())
                ->setEmail($card->getEmail())
                ->setAddressLine1($card->getBillingAddress1())
                ->setLocality($card->getBillingCity())
                ->setCountry($card->getBillingCountry())
                ->setPostalCode($card->getBillingPostcode());

            if (!empty($card->getBillingState())) {
                $billingAddress->setRegion($card->getBillingState());
            }

            $payment->setBillingAddress($billingAddress);
        }

        if (!empty($card->getShippingAddress1())) {
            $shippingAddress = (new Address())
                ->setFirstName($card->getFirstName())
                ->setLastName($card->getLastName())
                ->setEmail($card->getEmail())
                ->setAddressLine1($card->getShippingAddress1())
                ->setLocality($card->getShippingCity())
                ->setCountry($card->getShippingCountry())
                ->setPostalCode($card->getShippingPostcode());

            if (!empty($card->getShippingState())) {
                $shippingAddress->setRegion($card->getShippingState());
            }

            $payment->setShippingAddress($shippingAddress);
        }

        return $payment;
    }

    /**
     * {@inheritDoc}
     */
    public function sendData($data)
    {
        try {
            $client = new PaymentsClient($this->getAccessKey(), $this->getSecretKey(), $this->getTestMode() ? AbstractClient::ENVIRONMENT_SANDBOX : AbstractClient::ENVIRONMENT_LIVE);
            $response = $client->createOrder($data);

            if (empty($response['paymentUrl'])) {
                throw new \Exception('missing payment url');
            }

            return $this->response = new PurchaseResponse($this, $response);
        } catch (RequestException $e) {
            throw new InvalidRequestException('Request failed: ' . $e->getResponse(), $e->getCode(), $e);
        } catch (\Throwable $e) {
            throw new InvalidRequestException('Failed to request purchase: ' . $e->getMessage(), 0, $e);
        }
    }
}
