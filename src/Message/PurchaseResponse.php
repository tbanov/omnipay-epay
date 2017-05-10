<?php

namespace Omnipay\Epay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Class PurchaseResponse
 * @package Omnipay\Epay\Message
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * The embodied request object.
     *
     * @var AbstractRequest
     */
    protected $request;

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->request->getEndpoint() . '?' . http_build_query($this->data);
    }

    /**
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * @return mixed
     */
    public function getRedirectData()
    {
        $this->getRedirectResponse();
    }
}
