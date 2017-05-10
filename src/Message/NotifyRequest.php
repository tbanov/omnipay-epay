<?php
/**
 * Created by PhpStorm.
 * User: vansa
 * Date: 15-3-21
 * Time: 13:40
 */

namespace Omnipay\Epay\Message;

use Omnipay\Common\Exception\InvalidRequestException;


/**
 * Class NotifyRequest
 * @package Omnipay\Epay\Message
 */
class NotifyRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        if (!isset($this->data)) {
            $message = $this->getContent();
            if (!isset($message['encoded']) || !isset($message['checksum'])) {
                throw new InvalidRequestException("Missing required parameters");
            }

            $ENCODED = $message['encoded'];
            $CHECKSUM = $message['checksum'];

            $hmac = hash_hmac('sha1', $ENCODED, $this->getSignature());

            // Check if the received CHECKSUM is OK
            if ($hmac == $CHECKSUM) {
                $data = base64_decode($ENCODED);
                $lines_arr = explode("\n", $data);
                $regs_text = '';
                $notify_text = '';
                foreach ($lines_arr as $line) {
                    if (preg_match("/^INVOICE=(\d+):STATUS=(PAID|DENIED|EXPIRED)(:PAY_TIME=(\d+):STAN=(\d+):BCODE=([0-9a-zA-Z]+))?$/", $line, $regs)) {
                        $status = isset($regs[2]) ? $regs[2] : null;
                        $invoice = isset($regs[1]) ? $regs[1] : null;
                        $data = [
                            'invoice' => $invoice,
                            'status' => $status,
                            'pay_time' => isset($regs[4]) ? $regs[4] : null,
                            'stan' => isset($regs[5]) ? $regs[5] : null,
                            'bcode' => isset($regs[6]) ? $regs[6] : null,
                            'notify_text' => in_array($status, ['PAID', 'DENIED', 'EXPIRED']) ? "INVOICE=$invoice:STATUS=OK\n" : "INVOICE=$invoice:STATUS=ERR\n",
                        ];
                    }
                }

                $this->data = $data;
            } else {
                $this->data = [
                    'notify_text' => "ERR=Not valid CHECKSUM\n"
                ];
            }
        }

        return $this->data;
    }

    /**
     * @param mixed $data
     * @return NotifyResponse
     */
    public function sendData($data)
    {
        return $this->response = new NotifyResponse($this, $data);
    }

    /**
     * @return array
     */
    public function getContent()
    {
        return $this->httpRequest->request->all();
    }
}