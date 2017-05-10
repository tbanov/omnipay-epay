<?php

namespace Omnipay\Epay\Message;


/**
 * Class PurchaseRequest
 * @package Omnipay\Epay\Message
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        if (!isset($this->data)) {
            $this->validate('amount', 'returnUrl');

            if (!$this->getTransactionId()) {
                $this->setTransactionId(substr(number_format(time() * rand(), 0, '', ''), 0, 10));
            }

            // Expiration date - 3 days affter purchase
            $exp_date = date('d.m.Y', mktime(0, 0, 0, date("m"), date("d") + 3, date("Y")));
            $descr = $this->getDescription();

            $en = "<<<DATA\nMIN={$this->getMin()}\nINVOICE={$this->getTransactionId()}\nAMOUNT=" . $this->getAmount() . "\nEXP_TIME={$exp_date}\nDESCR={$descr}";

            $ENCODED = base64_encode($en);
            $CHECKSUM = hash_hmac('sha1', $ENCODED, $this->getSignature());

            $data = [
                'PAGE' => 'paylogin',
                'ENCODED' => $ENCODED,
                'CHECKSUM' => $CHECKSUM,
                'URL_OK' => $this->getReturnUrl(),
                'URL_CANCEL' => $this->getCancelUrl(),
            ];

            $this->data = $data;
        }

        return $this->data;
    }

    /**
     * @param mixed $data
     * @return PurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
