<?php

namespace Omnipay\Epay\Message;

/**
 * Class AbstractRequest
 * @package Omnipay\Epay\Message
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * @var string
     */
    protected $liveEndpoint = 'https://www.epay.bg/';

    /**
     * @var string
     */
    protected $testEndpoint = 'https://demo.epay.bg/';

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * @return mixed
     */
    public function getMin()
    {
        return $this->getParameter('min');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setMin($value)
    {
        return $this->setParameter('min', $value);
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->getParameter('signature');
    }

    /**
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setSignature($value)
    {
        return $this->setParameter('signature', $value);
    }
}
