<?php

namespace Omnipay\Epay;

use Omnipay\Common\AbstractGateway;


/**
 * Class Gateway
 * @package Omnipay\Epay
 *
 * @link https://demo.epay.bg
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Epay';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'min' => '',
            'signature' => '',
            'testMode' => true,
        ];
    }

    /**
     * @return string
     */
    public function getMin()
    {
        return $this->getParameter('min');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setMin($value)
    {
        return $this->setParameter('min', $value);
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->getParameter('signature');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setSignature($value)
    {
        return $this->setParameter('signature', $value);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Epay\Message\PurchaseRequest', $parameters);
    }

    /**
     * Handle notification callback.
     *
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function acceptNotification(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Epay\Message\NotifyRequest', $parameters);
    }
}
