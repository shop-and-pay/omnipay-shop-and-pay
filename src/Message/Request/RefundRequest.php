<?php

namespace Omnipay\ShopAndPay\Message\Request;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\ShopAndPay\Message\Response\RefundResponse;
use ShopAndPay\Models\Request\Transaction;
use ShopAndPay\ShopAndPay;
use ShopAndPay\ShopAndPayException;

/**
 * @see https://shop-and-pay.readme.io/reference#refund-a-transaction
 */
class RefundRequest extends AbstractRequest
{
    /**
     * @param string $value
     * @return $this
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setInstance($value)
    {
        return $this->setParameter('instance', $value);
    }

    /**
     * @return array
     */
    public function getData()
    {
        $this->validate('apiKey', 'instance', 'transactionReference');

        $data = [];
        $data['apiKey'] = $this->getApiKey();
        $data['instance'] = $this->getInstance();
        $data['id'] = $this->getTransactionReference();

        if ($this->getAmountInteger()) {
            $data['amount'] = $this->getAmountInteger();
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * @return string
     */
    public function getInstance()
    {
        return $this->getParameter('instance');
    }

    /**
     * @param array $data
     * @return RefundResponse
     * @throws InvalidRequestException
     */
    public function sendData($data)
    {
        try {
            $shopandpay = new ShopAndPay($data['instance'], $data['apiKey']);

            $transaction = new Transaction();
            $transaction->setId($data['id']);
            $transaction->setAmount($data['amount'] ?? 0);

            $response = $shopandpay->refund($transaction);
        } catch (ShopAndPayException $e) {
            throw new InvalidRequestException($e->getMessage());
        }

        return $this->response = new RefundResponse($this, $response);
    }
}
