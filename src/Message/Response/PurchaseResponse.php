<?php

namespace Omnipay\ShopAndPay\Message\Response;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * @see https://shop-and-pay.readme.io/reference#gateway
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * When you do a `purchase` the request is never successful because
     * you need to redirect off-site to complete the purchase.
     *
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getRedirectUrl()
    {
        return $this->data->getLink();
    }

    public function getTransactionReference()
    {
        return $this->data->getId();
    }
}
