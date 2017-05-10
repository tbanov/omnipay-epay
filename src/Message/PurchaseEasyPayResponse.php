<?php

namespace Omnipay\Epay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class PurchaseEasyPayResponse
 * @package Omnipay\Epay\Message
 */
class PurchaseEasyPayResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->request->endpoint . '?' . http_build_query($this->data);
    }

    /**
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        if (!$this->isRedirect()) {
            return (string)parent::getMessage();
        }
    }

    /**
     * @return mixed
     */
    public function getRedirectData()
    {
        return $this->data['idn'];
    }
}
