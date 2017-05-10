<?php

namespace Omnipay\Epay;

/**
 * Class EasypayGateway
 * @package Omnipay\Epay
 */
class EasypayGateway extends Gateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Easypay';
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Epay\Message\PurchaseEasyPayRequest', $parameters);
    }
}
