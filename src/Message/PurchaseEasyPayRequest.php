<?php

namespace Omnipay\Epay\Message;

/**
 * Class PurchaseEasyPayRequest
 * @package Omnipay\Epay\Message
 */
class PurchaseEasyPayRequest extends PurchaseRequest
{
    /**
     * @var string
     */
    public $endpoint = 'https://www.epay.bg/ezp/reg_bill.cgi';

    /**
     * @return string
     */
    public function setEndPoint()
    {
        return $this->endpoint = $this->getTestMode() ? 'https://demo.epay.bg/ezp/reg_bill.cgi' : $this->endpoint;
    }

    /**
     * @param mixed $data
     * @return PurchaseEasyPayResponse
     */
    public function sendData($data)
    {
        $url = $this->setEndPoint() . '?' . http_build_query($data);
        $data['idn'] = $this->httpClient->get($url)->send()->getBody(true);
        return $this->response = new PurchaseEasyPayResponse($this, $data);
    }
}
