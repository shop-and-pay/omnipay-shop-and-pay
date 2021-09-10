<?php

namespace Omnipay\ShopAndPay\Message\Response;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * @see https://shop-and-pay.readme.io/reference#retrieve-a-transaction
 */
class FetchTransactionResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return $this->data->getStatus() === 'confirmed';
    }

    public function getTransactionReference()
    {
        return $this->data->getId();
    }
}
