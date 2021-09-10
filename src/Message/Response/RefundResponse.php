<?php

namespace Omnipay\ShopAndPay\Message\Response;

use Omnipay\Common\Message\AbstractResponse;

/**
 * @see https://shop-and-pay.readme.io/reference#refund-a-transaction
 */
class RefundResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return !empty($this->data->getId());
    }
}
