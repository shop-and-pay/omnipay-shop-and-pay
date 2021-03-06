<?php

namespace Omnipay\ShopAndPay\Message\Request;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\ShopAndPay\Message\Response\FetchTransactionResponse;
use ShopAndPay\Models\Request\Transaction;
use ShopAndPay\ShopAndPay;
use ShopAndPay\ShopAndPayException;

/**
 * @see https://shop-and-pay.readme.io/reference#retrieve-a-transaction
 */
class FetchTransactionRequest extends AbstractRequest
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
     * @return FetchTransactionResponse
     */

    /**
     * @param array $data
     * @return FetchTransactionResponse
     * @throws InvalidRequestException
     */
    public function sendData($data)
    {
        try {
            $shopandpay = new ShopAndPay($data['instance'], $data['apiKey']);
            $transaction = new Transaction();
            $transaction->setId($data['id']);
            $response = $shopandpay->getOne($transaction);
        } catch (ShopAndPayException $e) {
            throw new InvalidRequestException($e->getMessage());
        }

        return $this->response = new FetchTransactionResponse($this, $response);
    }
}
